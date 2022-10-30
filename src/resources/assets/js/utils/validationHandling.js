let ValidationErrorHandler = {
    created() {
        this.errors = {};
    },
    methods: {
        syncErrors(error){
            if(typeof error !== 'undefined'){
                if(typeof error.response !== 'undefined'
                    && error.hasOwnProperty('response')
                    && error.response.hasOwnProperty('data'))
                {
                    if(error.response.data.hasOwnProperty('errors')){
                        this.errors = error.response.data.errors;
                        console.log(error.response.data.errors);
                    }
                }
            }
        },
        clearErrors(){
            this.errors = {};
        },
        hasErrors(field) {
            return this.errors.hasOwnProperty(field);
        },
        getError(field){
            return this.errors.hasOwnProperty(field) ? this.errors[field][0] : null;
        },
        getErrors(field){
            return this.errors.hasOwnProperty(field) ? this.errors[field] : null;
        }
    }
};
export default ValidationErrorHandler;
