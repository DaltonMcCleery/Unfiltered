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
                                       name="name" :value="user.name" required>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">
                                Username <small style="color: orangered;">unique</small>
                            </label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control"
                                       name="username" :value="user.username" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                Email Address
                            </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control"
                                       name="email" :value="user.email" required>
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
    </div>

</template>

<script>
    export default {
        data() {
            return {
                name: null,
                username: null,
                email: null,
                new_password: '',
                new_password_conf: '',
                endpoint: "api/profile"
            };
        },

        props: {
            auth_user: String,
        },

        created() {
            // Convert passed Auth String into a JSON object
            this.user = JSON.parse(this.auth_user);
        },

        methods: {

            update() {
                console.log('Updating!')
            }
        }
    };
</script>