@extends('admin.dashboard')

@section('title', 'Profil')

@section('admin')

    <style>
        .profile-wrapper {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 25px;
        }

        .profile-card {

            background: #fff;

            border-radius: 24px;

            padding: 30px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .05);

            position: relative;

            overflow: hidden;
        }

        .profile-cover {

            height: 110px;

            background:
                linear-gradient(135deg,
                    #6366f1,
                    #8b5cf6);

            border-radius: 18px;

            margin-bottom: 70px;
        }

        .profile-avatar {

            width: 120px;
            height: 120px;

            border-radius: 50%;

            border: 5px solid #fff;

            object-fit: cover;

            position: absolute;

            left: 50%;

            transform: translateX(-50%);

            top: 55px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .15);

            background: #fff;

        }

        .profile-name {

            text-align: center;
            margin-top: -15px;
        }

        .profile-name h3 {

            font-size: 24px;
            margin-bottom: 5px;
        }

        .profile-name p {

            color: #64748b;
            font-size: 14px;
        }

        .badge-role {

            display: inline-block;

            padding: 8px 18px;

            border-radius: 30px;

            background:
                rgba(99, 102, 241, .1);

            color: #6366f1;

            font-size: 13px;

            margin-top: 10px;
        }

        .profile-stats {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            margin-top: 30px;

            border-top:
                1px solid #eee;

            padding-top: 25px;

            text-align: center;
        }

        .profile-stats h4 {

            font-size: 20px;
            margin-bottom: 5px;
        }

        .profile-stats span {

            font-size: 13px;
            color: #64748b;
        }


        /* RIGHT */

        .edit-card {

            background: #fff;

            padding: 30px;

            border-radius: 24px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .05);

        }

        .section-title {

            font-size: 20px;
            font-weight: 600;

            margin-bottom: 25px;
        }

        .form-group {

            margin-bottom: 20px;
        }

        .form-group label {

            display: block;

            margin-bottom: 8px;

            font-weight: 500;
        }

        .form-control {

            width: 100%;

            padding: 13px;

            border-radius: 12px;

            border: 1px solid #ddd;

            transition: .3s;
        }

        .form-control:focus {

            outline: none;

            border-color: #6366f1;

            box-shadow:
                0 0 0 5px rgba(99, 102, 241, .1);

        }

        .action {

            display: flex;

            justify-content: flex-end;

            gap: 10px;

            margin-top: 30px;
        }

        .btn-back {

            padding: 12px 20px;

            border-radius: 12px;

            border: none;

            background: #f1f5f9;

            cursor: pointer;
        }

        .btn-save {

            padding: 12px 25px;

            border: none;

            border-radius: 12px;

            background:
                linear-gradient(135deg,
                    #6366f1,
                    #8b5cf6);

            color: white;

            cursor: pointer;

            font-weight: 600;
        }

        .btn-save:hover {

            opacity: .9;
        }


        /* DARK */

        body.dark .profile-card,
        body.dark .edit-card {

            background: #020617;

            border:
                1px solid #1e293b;

        }

        body.dark .form-control {

            background: #0f172a;

            border:
                1px solid #1e293b;

            color: white;

        }

        body.dark .profile-stats {

            border-color: #1e293b;
        }


        /* RESPONSIVE */

        @media(max-width:900px) {

            .profile-wrapper {

                grid-template-columns: 1fr;

            }

        }
    </style>



    <div class="profile-wrapper">


        <!-- KIRI -->

        <div class="profile-card">

            <div class="profile-cover"></div>

            <img src="{{ $admin->foto ? asset('storage/' . $admin->foto) : asset('assets/images/users/profile-pic.jpg') }}"
                class="profile-avatar">


            <div class="profile-name">

                <h3>

                    {{ $admin->name }}

                </h3>

                <p>

                    {{ $admin->email }}

                </p>

                <div class="badge-role">

                    Administrator

                </div>

            </div>

        </div>



        <!-- KANAN -->

        <div class="edit-card">

            <div class="section-title">

                Edit Profil

            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-group">

                    <label>

                        Nama

                    </label>

                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="form-control">

                </div>


                <div class="form-group">

                    <label>

                        Username

                    </label>

                    <input type="text" value="{{ $admin->username }}" readonly class="form-control">

                </div>


                <div class="form-group">

                    <label>

                        Email

                    </label>

                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="form-control">

                </div>


                <div class="form-group">

                    <label>

                        Foto Profil

                    </label>

                    <input type="file" name="foto" class="form-control">

                </div>


                <div class="action">

                    <a href="{{ route('admin.dashboard') }}">

                        <button type="button" class="btn-back">

                            Kembali

                        </button>

                    </a>

                    <button type="submit" class="btn-save">

                        Update Profil

                    </button>

                </div>


            </form>

        </div>

    </div>

@endsection
