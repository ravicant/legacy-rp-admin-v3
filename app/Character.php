<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * A character made by a player.
 *
 * @package App
 */
class Character extends Model
{
    use HasFactory;

    /**
     * Whether to use timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'character_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'license_identifier',
        'character_slot',
        'gender',
        'first_name',
        'last_name',
        'date_of_birth',
        'blood_type',
        'backstory',
        'is_dead',
        'cash',
        'bank',
        'stocks_balance',
        'job_name',
        'department_name',
        'position_name',
        'character_created',
        'character_creation_timestamp',
        'character_deleted',
        'character_deletion_timestamp',
        'character_creation_time',
        'last_loaded',
        'ped_model_hash',
        'tattoos_data',
        'coords',
        'character_data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'character_slot'               => 'integer',
        'gender'                       => 'integer',
        'cash'                         => 'integer',
        'bank'                         => 'integer',
        'character_creation_time'      => 'integer',
        'stocks_balance'               => 'double',
        'character_created'            => 'boolean',
        'character_creation_timestamp' => 'datetime',
        'character_deleted'            => 'boolean',
        'character_deletion_timestamp' => 'datetime',
        'weekly_playtime'              => 'array',
    ];

    /**
     * @var array
     */
    private static $cache = [];

    /**
     * Gets the full name by concatenating first name and last name together.
     *
     * @return string
     */
    protected function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Gets the total amount of money by adding cash and bank together.
     *
     * @return int
     */
    protected function getMoneyAttribute(): int
    {
        return $this->cash + $this->bank;
    }

    public static function getOutfits(int $characterId): int
    {
        return DB::table('outfits')->where('character_id', '=', $characterId)->count();
    }

    /**
     * @param int $characterId
     * @return Character|null
     */
    public static function find(int $characterId): ?self
    {
        if (!isset(self::$cache[$characterId])) {
            self::$cache[$characterId] = self::query()->where('character_id', '=', $characterId)->first();
        }

        return self::$cache[$characterId];
    }

    /**
     * Gets player relationship.
     *
     * @return BelongsTo
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'license_identifier', 'license_identifier');
    }

    /**
     * Gets the vehicles owned by this character.
     *
     * @return HasMany
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'owner_cid')->where('vehicle_deleted', '=', '0');
    }

    /**
     * Gets the properties owned by this character.
     *
     * @return HasMany
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'property_renter_cid');
    }

    /**
     * Gets the properties this character has access to.
     *
     * @return HasMany
     */
    public function accessProperties()
    {
        return Property::query()->select()->where("shared_keys", "LIKE", "%-" . $this->character_id . ";%")->get();
    }

    /**
     * Returns all licenses
     *
     * @return array
     */
    public function getLicenses(): array
    {
        $json = json_decode($this->character_data, true) ?? [];

        if (!isset($json['licenses']) || !is_array($json['licenses'])) {
            return [];
        }

        return $json['licenses'];
    }

    public function getRecentPlaytime(int $weeks): int
    {
        $after    = op_week_identifier() - $weeks;
        $playtime = 0;

        $weeklyPlaytime = $this->weekly_playtime ?? [];

        foreach ($weeklyPlaytime as $week => $time) {
            $week = intval($week);

            if ($week >= $after) {
                $playtime += $time;
            }
        }

        return $playtime;
    }

    /**
     * Returns a map of character_id->[character_name,licenseIdentifier]
     * This is used instead of a left join as it appears to be a lot faster
     *
     * @param array $source
     * @param string $sourceKey
     * @return array
     */
    public static function fetchIdNameMap(array $source, string $sourceKey): array
    {
        $ids = [];
        foreach ($source as $entry) {
            if (!in_array($entry[$sourceKey], $ids)) {
                $ids[] = $entry[$sourceKey];
            }
        }

        $characters = self::query()->whereIn('character_id', $ids)->select([
            'character_id', 'license_identifier', 'first_name', 'last_name',
        ])->get();
        $characterMap = [];
        foreach ($characters as $character) {
            $characterMap[$character->character_id] = [
                'license_identifier' => $character->license_identifier,
                'name'               => $character->first_name . ' ' . $character->last_name,
            ];
        }

        if (empty($characterMap)) {
            $characterMap['empty'] = 'empty';
        }

        return $characterMap;
    }

}
