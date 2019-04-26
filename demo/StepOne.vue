<template>
    <div style="padding: 2rem 3rem; text-align: left;">
        <div class="field">
            <label class="label">日期</label>
            <div class="control">
                <input :class="['input', ($v.form.recdata.$error) ? 'is-danger' : '']" type="date" placeholder="Text input"
                       v-model="form.recdata">
            </div>
            <p v-if="$v.form.recdata.$error" class="help is-danger">日期不对</p>
        </div>
        <!--<div class="field">-->
            <!--<label class="label">Email</label>-->
            <!--<div class="control">-->
                <!--<input :class="['input', ($v.form.demoEmail.$error) ? 'is-danger' : '']"  type="text" placeholder="Email input" v-model="form.demoEmail">-->
            <!--</div>-->
            <!--<p v-if="$v.form.demoEmail.$error" class="help is-danger">This email is invalid</p>-->
        <!--</div>-->
        <!--<div class="field">-->
            <!--<label class="label">Message</label>-->
            <!--<div class="control">-->
                <!--<textarea :class="['textarea', ($v.form.message.$error) ? 'is-danger' : '']"  placeholder="Textarea" v-model="form.message"></textarea>-->
            <!--</div>-->
        <!--</div>-->
    </div>
</template>

<script>
    import {validationMixin} from 'vuelidate'
    import {required, email} from 'vuelidate/lib/validators'

    export default {
        props: ['clickedNext', 'currentStep'],
        mixins: [validationMixin],
        data() {
            return {
                form: {
                    recdata: '',
//                    demoEmail: '',
//                    message: ''
                }
            }
        },
        validations: {
            form: {
//                username: {
//                    required
//                },
                recdata: {
                    required
                }
//                message: {
//                    required
//                }
            }
        },
        watch: {
            $v: {
                handler: function (val) {
                    if(!val.$invalid) {
                        sessionStorage.setItem('recdata', this.form.recdata);
//                        console.log('recdata0', this.form.recdata);
                        this.$emit('can-continue', {value: true});
                    } else {
                        this.$emit('can-continue', {value: false});
                        setTimeout(()=> {
                            this.$emit('change-next', {nextBtnValue: false});
                        }, 3000)
                    }
                },
                deep: true
            },

            clickedNext(val) {
                console.log(val);
                if(val === true) {
                    this.$v.form.$touch();
                }
            }
        },
        mounted() {
            if(!this.$v.$invalid) {
                this.$emit('can-continue', {value: true});
            } else {
                this.$emit('can-continue', {value: false});
            }
        }
    }
</script>