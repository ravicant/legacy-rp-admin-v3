<?php

namespace App\Http\Controllers;

use App\Ban;
use App\Helpers\GeneralHelper;
use App\Helpers\OPFWHelper;
use App\Http\Resources\BanResource;
use App\Http\Resources\PlayerIndexResource;
use App\Server;
use App\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

class StaffChatController extends Controller
{

    /**
     * Renders the staff chat.
     *
     * @param Request $request
     * @return Response
     */
    public function staff(Request $request): Response
    {
        return Inertia::render('StaffChat', []);
    }

    /**
     * Add external staff messages
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function externalStaffChat(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (!$user) {
            return back()->with('error', 'Something went wrong.');
        }

        $message = trim($request->input('message'));

        if (!$message || strlen($message) > 250) {
            return back()->with('error', 'Invalid or empty message.');
        }

        $serverIp = Server::getFirstServer();

        $status = OPFWHelper::staffChat($serverIp, $user->player->license_identifier, $message);

        return $status->redirect();
    }

    public function staffChat()
    {
        $logs = DB::select("SELECT player_name, details, UNIX_TIMESTAMP(timestamp) as timestamp FROM user_logs LEFT JOIN users ON identifier = license_identifier WHERE action = 'Staff Message' ORDER BY timestamp DESC");

        $text = [];

        $lastDay = false;

        foreach ($logs as $log) {
            $date = date('D, jS M Y', $log->timestamp);

            if ($date != $lastDay) {
                $text[] = "\n<b style='border-bottom: 1px dashed #fff;margin: 10px 0 5px;display: inline-block;'>- - - " . $date . " - - -</b><table>";

                $lastDay = $date;
            }

            $time = date('H:i', $log->timestamp);

            $re = '/(?<=staff chat: `).+?`$/m';
            $message = preg_match_all($re, $log->details, $matches, PREG_SET_ORDER, 0);

            if (isset($matches[0][0])) {
                $message = $matches[0][0];
            } else {
                $message = $log->details;
            }

            $text[] = '<tr><td>' . $time . '</td><td><b>' . $log->player_name . '</b></td><td><i>' . $message . '</i></td></tr>';
        }

        return $this->fakeText(200, implode("\n", $text) . '</table><style>td:not(:last-child){white-space:nowrap}td{padding:5px 7px;font-size:13px}tr:nth-child(odd){background:rgba(255,255,255,.05)}table{border-collapse:collapse}</style>');
    }

}
