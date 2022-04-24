export default {
    methods: {
        ttt(str) {
            return Nova.config('tiptapTranslations')[str] 
                ? Nova.config('tiptapTranslations')[str]
                : str
        },
    }
}
