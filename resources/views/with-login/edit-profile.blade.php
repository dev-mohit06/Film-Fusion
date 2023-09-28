@extends('blueprints.with-login-main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/edit-profile.css') }}">
@endpush


@section('title')
    Edit Profile
@endsection

@section('container')
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <section class="container profile-container">
        <h1>Edit Profile</h1>
        <form class="form" id="edit_profile">
            @csrf
            <div class="input-box">
                <label>Username</label>
                <input type="text" placeholder="Enter username" id="username" value="{{ $user_data->username }}"
                    name="username" required />
                <span class="err" id="err-username"></span>
            </div>
            <div class="input-box">
                <label>Email Address</label>
                <input type="text" placeholder="Enter email address" id="email" value="{{ $user_data->email }}"
                    name="email" required />
                <span class="err" id="err-email"></span>
            </div>
            <div class="column">
                <div class="input-box">
                    <label>New Password</label>
                    <input type="password" placeholder="Enter the password" id="password" name="password" />
                    <span class="err" id="err-password"></span>
                </div>
                <div class="input-box">
                    <label>Profile Picture</label>
                    <input type="file" id="profile_picture" name="profile_picture" />
                    <span class="err" id="err-profile_picture"></span>
                </div>
            </div>
            <button type="submit">Submit</button>
        </form>
    </section>
    <br>
    <br>
    <br>
    <br>
@endsection

@push('scripts')
    <script>
        // Toast notifications
        var Toast = new Notyf({
            duration: 3000,
            position: {
                x: 'center',
                y: 'top',
            },
        });

        let waitingMessage;
        const updateForm_fields = [{
                name: 'username',
                regex: /^[a-z0-9_\.]+$/,
                error: 'Please enter a valid username'
            },
            {
                name: 'email',
                regex: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
                error: 'Please enter a valid email address.'
            },
        ];
        $(document).ready(function() {
            $("#edit_profile").on("submit", function(e) {
                e.preventDefault();
                let count = 0;

                updateForm_fields.forEach(field => {
                    let fieldValue = $("#" + field.name).val();
                    let errorElement = $("#err-" + field.name);
                    if (!fieldValue.match(field.regex)) {
                        errorElement.html(field.error);
                        count++;
                    } else {
                        errorElement.html("");
                    }
                });

                let password = $("#password").val();
                if (password != "") {
                    if (password.length < 8) {
                        $("#err-password").html("at least 8 character long.");
                        count++;
                    } else {
                        $("#err-password").html("");
                    }
                } else {
                    $("#err-password").html("");
                }

                const pictureInput = $("#profile_picture")[0];
                const pictureErrorElement = $("#err-profile_picture");
                if (pictureInput.files.length > 0) {
                    const pictureFile = pictureInput.files[0];
                    const allowedFormats = ["image/jpeg", "image/png"]; // Add more formats if needed

                    if (pictureFile.size > 5 * 1024 * 1024) { // 5MB maximum size
                        pictureErrorElement.html("The profile picture size exceeds the limit of 5MB.");
                        count++;
                    } else if (!allowedFormats.includes(pictureFile.type)) {
                        pictureErrorElement.html("Please upload a profile picture in JPEG or PNG format.");
                        count++;
                    } else {
                        pictureErrorElement.html("");
                    }
                } else {
                    pictureErrorElement.html("");
                }


                if (count == 0) {
                    let form = $("#edit_profile")[0];
                    let formData = new FormData(form);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.edit-profile.updateUser') }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend : function(){
                            waitingMessage = Toast.open({
                                type: 'info',
                                message: "Just a moment...",
                                background: 'blue',
                                duration: 0,
                            });
                        },
                        success: function(response) {
                            Toast.dismiss(waitingMessage);
                            if(response == -1){
                                Toast.error("Please enter the diffrent username or email");
                            }else{
                                Toast.success("Data update successfully");
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
