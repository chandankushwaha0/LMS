<?php include_once ("./includes/header.php"); ?>

<style>

    .card-registration .select-input.form-control[readonly]:not([disabled]) {
        font-size: 1rem;
        line-height: 2.15;
        padding-left: .75em;
        padding-right: .75em;
    }

    .card-registration .select-arrow {
        top: 13px;
    }

    .gradient-custom-2 {
        /* fallback for old browsers */
        background: #a1c4fd;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1))
    }

    .bg-indigo {
        background-color: #4835d4;
    }

    @media (min-width: 992px) {
        .card-registration-2 .bg-indigo {
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
        }
    }

    @media (max-width: 991px) {
        .card-registration-2 .bg-indigo {
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }
    }

    .password {
        position: relative;
    }

    i {
        position: absolute;
        right: 19px;
        top: 40px;
        color: #000;

    }
</style>


<section class="h-100 h-custom gradient-custom-2">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
                <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <form action="">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <h3 class="fw-normal mb-5" style="color: #4835d4;">General Infomation</h3>

                                        <div class="row">
                                            <div class="col-md-6 mb-4 pb-2">

                                                <div data-mdb-input-init class="form-outline">
                                                    <input type="text" id="form3Examplev2"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="form3Examplev2">First name</label>
                                                </div>

                                            </div>
                                            <div class="col-md-6 mb-4 pb-2">

                                                <div data-mdb-input-init class="form-outline">
                                                    <input type="text" id="form3Examplev3"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="form3Examplev3">Last name</label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4 pb-2">

                                                <div data-mdb-input-init class="form-outline">
                                                    <label for="Faculty">Faculty</label>
                                                    <select class="select">
                                                        <option value="BCA">BCA</option>
                                                        <option value="BBA">BBA</option>
                                                        <option value="BHM">BHM</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-6 mb-4 pb-2">

                                                <div data-mdb-input-init class="form-outline">
                                                    <label for="Faculty">Semester</label>
                                                    <select class="select">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>

                                        <label class="form-label" for="form3Examplev3">Gender</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="female" id="femae">
                                            <label class="form-check-label" for="femae">
                                                Female
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="male" id="male">
                                            <label class="form-check-label" for="male">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="others" id="others">
                                            <label class="form-check-label" for="others">
                                                Others
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-6 bg-indigo text-white">
                                    <div class="p-5">
                                        <h3 class="fw-normal mb-5">Contact Details</h3>

                                        <div class="mb-4 pb-2">
                                            <div data-mdb-input-init class="form-outline form-white">
                                                <input type="number" id="phone" class="form-control form-control-lg" />
                                                <label class="form-label" for="phone">Phone Number</label>
                                            </div>
                                        </div>

                                        <div class="mb-4 pb-2">
                                            <div data-mdb-input-init class="form-outline form-white">
                                                <input type="text" id="address" class="form-control form-control-lg" />
                                                <label class="form-label" for="address">Address</label>
                                            </div>
                                        </div>


                                        <div class="mb-4">
                                            <div data-mdb-input-init class="form-outline form-white">
                                                <input type="text" id="form3Examplea9"
                                                    class="form-control form-control-lg" />
                                                <label class="form-label" for="form3Examplea9">Your Email</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-4 pb-2 password">

                                                <div data-mdb-input-init class="form-outline">
                                                    <p>
                                                        <label>Password:</label>
                                                        <input type="password" class="form-control form-control-lg"
                                                            name="password" id="password" />
                                                        <i class="fa-solid fa-eye" id="togglePassword"></i>
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="col-md-6 mb-4 pb-2 password">

                                                <div data-mdb-input-init class="form-outline">
                                                    <p>
                                                        <label>Confirm Password:</label>
                                                        <input type="password" class="form-control form-control-lg"
                                                            name="con-password" id="password2" />
                                                        <i class="fa-solid fa-eye" id="togglePassword2"></i>
                                                    </p>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="form-check d-flex justify-content-start mb-4 pb-3">
                                            <input class="form-check-input me-3" type="checkbox" value=""
                                                id="form2Example3c" />
                                            <label class="form-check-label text-white" for="form2Example3">
                                                I do accept the <a href="#!" class="text-white"><u>Terms and
                                                        Conditions</u></a> of your
                                                site.
                                            </label>
                                        </div>

                                        <button type="button" data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-light btn-lg" data-mdb-ripple-color="dark">Register</button>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    const togglePassword = document
        .querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', () => {
        // Toggle the type attribute using
        // getAttribure() method
        const type = password
            .getAttribute('type') === 'password' ?
            'text' : 'password';
        password.setAttribute('type', type);
    });


    const togglePassword2 = document
        .querySelector('#togglePassword2');
    const password2 = document.querySelector('#password2');
    togglePassword2.addEventListener('click', () => {
        // Toggle the type attribute using
        // getAttribure() method
        const type = password2
            .getAttribute('type') === 'password' ?
            'text' : 'password';
        password2.setAttribute('type', type);
    });
</script>

<?php include_once ("./includes/footer.php"); ?>

