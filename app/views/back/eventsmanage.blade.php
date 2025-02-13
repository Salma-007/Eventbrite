@extends('back.layout')

@section('content')
    <!-- Event Management Section -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <!-- Total Events Card -->
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Total Events</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <p class="text-center text-muted">Total number of events: {{ count($events) }}</p>
              </div>
            </div>
          </div>
          <!-- End Total Events Card -->

          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Manage Events</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <!-- Event Cards -->
                @if(empty($events))
                    <p class="text-center text-muted">No events found.</p>
                @else
                    @foreach($events as $event)
                        <div class="event-card">
                            <div class="row"> 
                                <div class="col-md-3">
                                    <img src="{{ '/assets/uploads/' . $event['couverture'] }}" alt="Event Cover">
                                </div>
                                <div class="col-md-9">
                                    <h4>{{ $event['title'] }}</h4>
                                    <p><strong>Category:</strong> {{ $event['category_name'] }}</p>
                                    <p><strong>Organizer:</strong> {{ $event['organizer_name'] }}</p>
                                    <p><strong>Date:</strong> {{ $event['date'] }}</p>
                                    <p><strong>Location:</strong> {{ $event['location'] }}</p>
                                    <div class="actions">
                                        <a href="/accept-event?id={{ $event['id'] }}" class="btn btn-success btn-sm">Accept</a>
                                        <a href="/refuse-event?id={{ $event['id'] }}" class="btn btn-danger btn-sm">Refuse</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
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