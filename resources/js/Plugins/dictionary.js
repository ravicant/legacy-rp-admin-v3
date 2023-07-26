import { get } from "axios";

const Dictionary = {
    async install(Vue, options) {
        let dictionary,
            badDictionary;

        const loadDictionaryFile = async (file, onProgress, offset, maxPercentage) => {
            const data = await get(file, {
                onDownloadProgress: progressEvent => {
                    const current = (progressEvent.loaded / progressEvent.total) * 100,
                        percentage = Math.floor((current + offset) / maxPercentage);

                    onProgress(percentage);
                }
            });


            const words = data.data.split("\n");

            return words.reduce((map, word) => {
                if (word.length <= 3) return map;

                map.set(word, true);

                return map;
            }, new Map());
        };

        const findInDictionary = (words, map) => {
            const keys = Array.from(map.keys());

            return words.find(word => {
                return keys.find(key => {
                    return key.includes(word) || word.includes(key);
                });
            });
        };

        Vue.prototype.loadDictionaries = async function (onProgress) {
            dictionary = await loadDictionaryFile("/_data/dictionary.txt", onProgress, 0, 200);

            badDictionary = await loadDictionaryFile("/_data/bad_words.txt", onProgress, 100, 200);
        };

        Vue.prototype.checkCharacter = function (character) {
            if (!dictionary || !badDictionary) return false;

            const words = character.backstory.toLowerCase().split(/[^\w]+/g);

            const hasExactBadWord = words.find(word => {
                return dictionary.has(word);
            });

            if (hasExactBadWord) return "negative";

            if (findInDictionary(words, badDictionary)) return "negative";

            const hasEnglish = words.find(word => {
                return dictionary.has(word);
            });

            if (!hasEnglish) return "negative";

            return "positive";
        };
    },
}

export default Dictionary;
