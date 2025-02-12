@extends('back.layout')

@section('content')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Manage Categories</h6>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                Add New Category
              </button>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                <p class="text-xs font-weight-bold mb-0" style="margin-left: 20px;">{{ $category['name'] }}</p>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editCategoryModal" data-id="{{ $category['id']}}" data-name="{{ $category['name'] }}">
                                    Update
                                </button>
                                <a href="/deleteCategorie?id={{ $category['id'] }}" class="btn btn-danger btn-sm" data-id="{{ $category['id'] }}">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method='POST' action='/addcategorie' >
              <div class="mb-3">
              @if(isset($errorMessage))
                <div class="alert alert-danger">
                    {{ $errorMessage }}
                </div>
              @endif
                <label for="categoryName" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Enter category name">
              </div>
              <button type="submit" class="btn btn-primary">Add Category</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/updateCategorie" method="POST">
            <input type="hidden" name="categoryId" id="editCategoryId">
              <div class="mb-3">
                <label for="editCategoryName" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="editCategoryName" name="categoryName" required>
              </div>
              <button type="submit" class="btn btn-primary">Update Category</button>
            </form>
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
  <script>
    const editCategoryModal = document.getElementById('editCategoryModal');
    editCategoryModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const categoryId = button.getAttribute('data-id');
    const categoryName = button.getAttribute('data-name');
    
    const modalCategoryId = editCategoryModal.querySelector('#editCategoryId');
    const modalCategoryName = editCategoryModal.querySelector('#editCategoryName');
    
    modalCategoryId.value = categoryId;
    modalCategoryName.value = categoryName;
    });
    </script>
@endsection