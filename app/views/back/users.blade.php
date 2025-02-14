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
                        <!-- Delete button -->
                        <button class="btn btn-link text-danger text-gradient px-3 mb-0 delete-user" data-id="{{ $user['id'] }}">
                            <i class="far fa-trash-alt me-2"></i>Delete
                        </button>

                        <!-- Ban button -->
                        @if ($user['is_banned'] == 0)
                            <button class="btn btn-link text-danger text-gradient px-3 mb-0 ban-user" data-id="{{ $user['id'] }}">
                                <i class="material-symbols-rounded text-sm me-2"></i>Ban
                            </button>
                        @else
                            <button class="btn btn-link text-dark px-3 mb-0 activate-user" data-id="{{ $user['id'] }}">
                                <i class="fas fa-pencil-alt text-dark me-2"></i>Activate
                            </button>
                        @endif
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
$(document).ready(function() {

// Action de suppression d'utilisateur
$("body").on("click", ".delete-user", function() {
    let userId = $(this).data("id");

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/delete-user", 
                method: "GET",
                data: { id: userId },
                success: function(response) {
                    if (response.status) {
                        Swal.fire("Deleted!", "User has been deleted.", "success").then(() => {
                            // Remove the user from the list dynamically
                            $(`button[data-id='${userId}']`).closest('li').remove();
                            loadUsers();
                        });
                    } else {
                      loadUsers();
                    }
                },
                error: function() {
                    Swal.fire("Error!", "There was an error deleting the user.", "error");
                }
            });
        }
    });
});

// Action de bannissement d'utilisateur
$("body").on("click", ".ban-user", function() {
    let userId = $(this).data("id");

    Swal.fire({
        title: "Are you sure?",
        text: "Do you really want to ban this user?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, ban it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/ban-user", 
                method: "GET",
                data: { id: userId },
                success: function(response) {
                    if (response.status) {
                        Swal.fire("Banned!", "User has been banned.", "success").then(() => {
                            let userElement = $(`button[data-id='${userId}']`).closest('li');
                            userElement.find('.badge').removeClass('bg-gradient-success').addClass('bg-gradient-secondary').text('Banned');
                            userElement.find('.ban-user').hide();  
                            userElement.find('.activate-user').show(); 
                            loadUsers();
                        });
                    } else {
                      loadUsers();
                    }
                },
                error: function() {
                    Swal.fire("Error!", "There was an error banning the user.", "error");
                }
            });
        }
    });
});

// Action d'activation d'utilisateur
$("body").on("click", ".activate-user", function() {
    let userId = $(this).data("id");

    Swal.fire({
        title: "Are you sure?",
        text: "Do you really want to activate this user?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, activate it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/activate-user", 
                method: "GET",
                data: { id: userId },
                success: function(response) {
                    if (response.status) {
                        Swal.fire("Activated!", "User has been activated.", "success").then(() => {
                            let userElement = $(`button[data-id='${userId}']`).closest('li');
                            userElement.find('.badge').removeClass('bg-gradient-secondary').addClass('bg-gradient-success').text('Active');
                            userElement.find('.activate-user').hide();
                            userElement.find('.ban-user').show();
                            loadUsers();
                        });
                    } else {
                      loadUsers();
                    }
                },
                error: function() {
                    Swal.fire("Error!", "There was an error activating the user.", "error");
                }
            });
        }
    });
});

// Charger la liste des utilisateurs via Ajax
function loadUsers() {
    $.ajax({
        url: '/get-users',
        method: 'GET',
        success: function(response) {
            if (response.users) {
                $('.list-group').empty();  

                response.users.forEach(function(user) {
                    let userElement = `
                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-3 text-sm">${user.name}</h6>
                                <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">${user.email}</span></span>
                                <span class="mb-2 text-xs">Account: 
                                    <span class="${user.is_banned == 0 ? 'badge badge-sm bg-gradient-success' : 'badge badge-sm bg-gradient-secondary'}">
                                        ${user.is_banned == 0 ? 'Active' : 'Banned'}
                                    </span>
                                </span>
                            </div>
                            <div class="ms-auto text-end">
                                <button class="btn btn-link text-danger text-gradient px-3 mb-0 delete-user" data-id="${user.id}">
                                    <i class="far fa-trash-alt me-2"></i>Delete
                                </button>

                                ${user.is_banned == 0 ? `
                                    <button class="btn btn-link text-danger text-gradient px-3 mb-0 ban-user" data-id="${user.id}">
                                        <i class="material-symbols-rounded text-sm me-2"></i>Ban
                                    </button>` : `
                                    <button class="btn btn-link text-dark px-3 mb-0 activate-user" data-id="${user.id}">
                                        <i class="fas fa-pencil-alt text-dark me-2"></i>Activate
                                    </button>`}
                            </div>
                        </li>
                    `;
                    $('.list-group').append(userElement); 
                });
            } else {
                Swal.fire("Error!", "Failed to load users.", "error");
            }
        },
        error: function() {
            Swal.fire("Error!", "There was an error loading the users.", "error");
        }
    });
}
loadUsers();
});

  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection