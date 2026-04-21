<!doctype html>
<html lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- Notifi CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.5.2/dist/css/tom-select.bootstrap5.css" rel="stylesheet">

    <title>Admin | @yield('title')</title>
    <style>
        .ts-control {
            min-height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            border-radius: .25rem;
            border: 1px solid #ced4da;
            background-color: #fff;
        }

        .ts-control.focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
        }

        .ts-dropdown {
            border-radius: .25rem;
            border: 1px solid #ced4da;
        }

        .ts-control .item {
            background: #007bff;
            color: #fff;
            border-radius: 3px;
            padding: 2px 6px;
            margin: 2px;
        }

        .ts-dropdown {
            background: #fff !important;
            z-index: 9999 !important;
            border: 1px solid #ced4da;
        }

        .ts-dropdown-content {
            background: #fff;
        }

        .ts-control {
            background-color: #fff;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* 2 colonnes */
            gap: 8px;
        }

        .image-item {
            width: 100%;
            aspect-ratio: 1 / 1;
            /* carré */
            overflow: hidden;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* crop propre */
        }

        .image-item {
            position: relative;
        }

        .btn-delete-image {
            position: absolute;
            top: 4px;
            right: 4px;
            background: rgba(255, 0, 0, 0.8);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-delete-image:hover {
            background: red;
        }

        .image-item {
            position: relative;
        }

        .image-loader {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, 0.6);
        }
    </style>
</head>

<body>


    <div class="container mt-3">
        @yield('content')
    </div>


    <!-- Principal Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Principal Jquery Validate -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

    <!-- Principal SweetAlert Notification -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>

    <!-- Notif Js Script -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- Tom Select Js Script -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.5.2/dist/js/tom-select.complete.min.js"></script>

    <!-- Principal Js Script -->
    <script type="module" src="{{ asset("assets/js/app.js") }}"></script>

    @yield("scripts")

</body>

</html>