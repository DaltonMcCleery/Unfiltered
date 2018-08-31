<template>

    <div class="col-md-8">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title is-centered">
                    My Profile Details
                </p>
            </header>
            <div class="card-content">
                <div class="content">
                    <form method="post" @submit.prevent="update">

                        <!-- Name -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">
                                Name
                            </label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control"
                                       name="name" v-model="name" required>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">
                                Username <small style="color: orangered;">unique</small>
                            </label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control"
                                       name="username" v-model="username" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                Email Address
                            </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control"
                                       name="email" v-model="email" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">
                                New Password
                            </label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control"
                                       name="password" v-model="new_password">
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                                Confirm New Password
                            </label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" v-model="new_password_conf">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="button is-success">
                                    Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>

        <!-- Success -->
        <b-notification type="is-success" v-if="success">
            Your Ninja Profile has been updated!
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
                name: null,
                old_name: '',
                username: null,
                old_username: '',
                email: null,
                old_email: '',
                new_password: '',
                new_password_conf: '',
                errors: null,
                success: null,
                endpoint: "api/profile/"
            };
        },

        props: {
            auth_user: String,
        },

        created() {
            // Convert passed Auth String into a JSON object
            this.user = JSON.parse(this.auth_user);

            // Set the default details
            this.name = this.user.name;
            this.username = this.user.username;
            this.email = this.user.email;

            // Setup backup models
            this.old_name = this.name;
            this.old_username = this.username;
            this.old_email = this.email;
        },

        methods: {

            update() {
                // Send a request to Update a User
                axios.post(this.endpoint+'update', {
                        user_id: this.user.id,
                        name: this.name,
                        username: this.username,
                        email: this.email
                    })
                    .then(({data}) => {
                        // Check response
                        if (data !== 'Updated') {
                            // Show errors
                            this.errors = data;

                            // Change the models to the old versions before the form submitted
                            this.name = this.old_name;
                            this.username = this.old_username;
                            this.email = this.old_email;
                        } else {
                            // Show success message
                            this.success = true;

                            // Set the old values to the new, updated details
                            this.old_name = this.name;
                            this.old_username = this.username;
                            this.old_email = this.email;
                        }
                    });
            }
        }
    };
</script>