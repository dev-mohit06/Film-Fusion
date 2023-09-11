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
                    <h1>12,324</h1>
                </div>
            </div>
        </div>
        <!-- End Of users -->
        <div class="movies">
            <span class="material-symbols-rounded">movie_filter</span>
            <div class="middle">
                <div class="left">
                    <h3>Total Movies</h3>
                    <h1>5,024</h1>
                </div>
            </div>

        </div>
        <!-- End Of Movies -->
        <div class="admins">
            <span class="material-symbols-rounded">shield_person</span>
            <div class="middle">
                <div class="left">
                    <h3>Total Admins</h3>
                    <h1>23</h1>
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
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Status</th>
                    <th>Create at</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mohit Paddhariya</td>
                    <td>___mohit06</td>
                    <td class="success-dark">Active</td>
                    <td>2023-06-30</td>
                </tr>
                <tr>
                    <td>Mohit Paddhariya</td>
                    <td>___mohit06</td>
                    <td class="success-dark">Active</td>
                    <td>2023-06-30</td>
                </tr>
                <tr>
                    <td>Mohit Paddhariya</td>
                    <td>___mohit06</td>
                    <td class="success-dark">Active</td>
                    <td>2023-06-30</td>
                </tr>
                <tr>
                    <td>Mohit Paddhariya</td>
                    <td>___mohit06</td>
                    <td class="success-dark">Active</td>
                    <td>2023-06-30</td>
                </tr>
                <tr>
                    <td>Mohit Paddhariya</td>
                    <td>___mohit06</td>
                    <td class="success-dark">Active</td>
                    <td>2023-06-30</td>
                </tr>
                <tr>
                    <td>Mohit Paddhariya</td>
                    <td>___mohit06</td>
                    <td class="success-dark">Active</td>
                    <td>2023-06-30</td>
                </tr>
                <tr>
                    <td>Mohit Paddhariya</td>
                    <td>___mohit06</td>
                    <td class="success-dark">Active</td>
                    <td>2023-06-30</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/resulable/sidebar.js') }}"></script>
@endpush