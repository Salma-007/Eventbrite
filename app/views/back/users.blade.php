@extends('back.layout')

@section('content')
    <!-- Event Management Section -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <!-- Total Events Card -->
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Total Users</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <p class="text-center text-muted">Total of users: {{ count($users) }}</p>
              </div>
            </div>
          </div>
          <!-- End Total Events Card -->

          <div class="row">
          <div class="col-md-8 mt-4">
          <div class="card">
            <div class="card-header pb-0 px-3">
              <h6 class="mb-0">Users Infos</h6>
            </div>
            <div class="card-body pt-4 p-3">
              <ul class="list-group">
              @foreach($users as $user)
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">{{ $user['name'] }}</h6>
                            <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">{{ $user['email'] }}</span></span>
                            <span class="mb-2 text-xs">Account: 
                                <span class="{{ $user['is_banned'] == 0 ? 'badge badge-sm bg-gradient-success' : 'badge badge-sm bg-gradient-secondary' }}">
                                    {{ $user['is_banned'] == 0 ? 'Active' : 'Banned' }}
                                </span>
                            </span>
                        </div>
                        <div class="ms-auto text-end">
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="/delete-user?id={{ $user['id'] }}"><i class="far fa-trash-alt me-2"></i>Delete</a>
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="/ban-user?id={{ $user['id'] }}"><i class="material-symbols-rounded text-sm me-2"></i>Ban</a>
                            <a class="btn btn-link text-dark px-3 mb-0" href="/activate-user?id={{ $user['id'] }}"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Ativate</a>
                        </div>
                    </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>

      </div>

        </div>
      </div>
    </div>
@endsection

@section('scripts')
<script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/argon-dashboard.min.js?v=2.1.0"></script>
@endsection