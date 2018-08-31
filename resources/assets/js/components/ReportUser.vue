<template>

    <div class="col-md-8 justify-content-center">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title is-centered">
                    Report a User
                </p>
            </header>
            <div class="card-content">
                <div class="content">
                    <form method="post" @submit.prevent="report">

                        <!-- Reported Username -->
                        <b-field label="Reported Player/Username">
                            <b-input v-model="username" required></b-input>
                        </b-field>

                        <b-field label="Reason">
                            <b-input maxlength="200" type="textarea" v-model="reason" required></b-input>
                        </b-field>

                        <button type="submit" class="button is-info">
                            Report Ninja
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <br>

        <!-- Success -->
        <b-notification type="is-success" v-if="success">
            We will be reviewing your report and taking action if necessary
        </b-notification>

        <!-- Errors -->
        <b-notification type="is-danger" v-if="errors">
            <ul>
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </b-notification>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                username: null,
                old_username: '',
                reason: null,
                old_reason: '',
                errors: null,
                success: null,
                endpoint: "api/report"
            };
        },

        props: {
            user_id: String,
        },

        created() {
            // do nothing
        },

        methods: {

            report() {
                // Send a request to Update a User
                axios.post(this.endpoint, {
                        reportee_id: this.user_id,
                        reported_user: this.username,
                        reason: this.reason
                    })
                    .then(({data}) => {
                        // Check response
                        if (data !== 'Success') {
                            // Show errors
                            this.errors = data;
                            this.success = null;

                            // Change the models to the old versions before the form submitted
                            this.username = this.old_username;
                            this.reason = this.old_reason;
                        } else {
                            // Show success message
                            this.success = true;
                            this.errors = null;

                            // Empty form
                            this.username = null;
                            this.reason = null;
                        }
                    });
            }
        }
    };
</script>