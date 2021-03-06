<?php

$error = false;

if (isset($_POST['signup'])) {
    $dict = [
        'fname' => '0',
        'lname' => '0',
        'username' => '0',
        'password' => '0',
        'position' => '0',
    ];

    foreach ($dict as $key => $value) {
        if (!isset($_POST[$key]) || trim($_POST[$key]) == '') {
            $error = true;
            echo $key . ' error';
            break;
        } else {
            $dict[$key] = trim($_POST[$key]);
        }
    }

    if ($error == false) {
        $password_hash = password_hash($dict['password'], PASSWORD_DEFAULT);

        if (
            $result = $db->row(
                'SELECT COUNT(id) AS count from users WHERE username = ?',
                $dict['username']
            )
        ) {
            if ($result['count'] == 0) {
                if (
                    $stmt = $db->insert('users', [
                        'first_name' => $dict['fname'],
                        'last_name' => $dict['lname'],
                        'username' => $dict['username'],
                        'password' => $password_hash,
                        'position' => $dict['position'],
                    ])
                ) {
                    header('Location: ?p=login');
                } else {
                    echo 'Cannot register';
                }
            } else {
                echo 'User with accname alr exist';
            }
        } else {
            echo 'Cannot register ' . $dict['username'];
        }
    }
}
?>

<body class="bg-default">
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-7 pt-lg-6">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-2 px-5">
                            <h1 class="text-white">Create an Account</h1>
                            <p class="text-lead text-white">Fill in account details to create an account.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--9 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="text-center text-muted mb-4">
                                <small>Fill in the following fields.</small>
                            </div>
                            <form method="post" action="" role="form">
                                <fieldset>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="First name" type="text"
                                                name="fname">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Last name" type="text"
                                                name="lname">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Username" type="text"
                                                name="username">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Password" type="password"
                                                name="password">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3 create-acc-select">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <select class="form-control create-acc-select" name="position">
                                                <option value="STAFF"> STAFF </option>
                                                <option value="MANAGER"> MANAGER </option>
                                                <option value="EXECUTIVE"> EXECUTIVE </option>
                                                <option value="CEO"> CEO </option>
                                                <option value="IT"> IT </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="signup" class="btn btn-primary my-4">Sign
                                            up</button>
                                        <a type="button" href="?p=accounts" class="btn btn-secondary my-4">Back</a>
                                    </div>
                                    <fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {
            window.scroll(0, 100);
        })
    </script>