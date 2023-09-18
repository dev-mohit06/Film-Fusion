@extends('blueprints.admin-main')

@section('title')
    Dashboard
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush


@section('container')
    <h1>Dashboard</h1>
    <!-- ========== Starting of Insight ========== -->
    <div class="insights">
        <div class="users">
            <span class="material-symbols-rounded">supervisor_account</span>
            <div class="middle">
                <div class="left">
                    <h3>Total Users</h3>
                    <h1>{{ $counts['userCount'] }}</h1>
                </div>
            </div>
        </div>
        <!-- End Of users -->
        <div class="movies">
            <span class="material-symbols-rounded">movie_filter</span>
            <div class="middle">
                <div class="left">
                    <h3>Total Movies</h3>
                    <h1>{{ $counts['movieCount'] }}</h1>
                </div>
            </div>
        </div>
        <!-- End Of Movies -->
        <div class="admins">
            <span class="material-symbols-rounded">shield_person</span>
            <div class="middle">
                <div class="left">
                    <h3>Total Admins</h3>
                    <h1>{{ $counts['adminCount'] }}</h1>
                </div>
            </div>

        </div>
        <!-- End Of admins -->
    </div>
    <!-- ========== End of Insight ========== -->

    <!-- ========== Starting of active-admin ========== -->
    <div class="active_admins">
        <h2>Active Admins</h2>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Create at</th>
                </tr>
            </thead>
            <tbody>
                {{-- {{ $admin->id }} --}}
                @foreach ($admin as $row)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->created_at }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/resulable/sidebar.js') }}"></script>
@endpush
