@extends('back.layout')

@section('content')
<div class="container-fluid py-4">
<div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Categories</p>
                    <h5 class="font-weight-bolder">
                      {{ $getCountCategorie }}
                      </h5>
                    </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row"> 
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Published Events</p>
                    <h5 class="font-weight-bolder">
                    {{ $CountAcceptedEvents }}
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Users</p>
                    <h5 class="font-weight-bolder">
                    {{ $getCountUSers }}
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Billets vendus</p>
                    <h5 class="font-weight-bolder">
                      $103,430
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  <div class="row mt-4">
    <div class="col-lg-7 mb-lg-0 mb-4">
      <div class="card z-index-2 h-100">
        <!-- Chart or other content -->
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card card-carousel overflow-hidden h-100 p-0">
        <!-- Carousel content -->
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-lg-7 mb-lg-0 mb-4">
      <div class="card ">
        <div class="card-header pb-0 p-3">
          <div class="d-flex justify-content-between">
            <h6 class="mb-2">Top Events</h6>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center ">
            <tbody>
              @foreach($topEvent as $event)
              <tr>
                <td class="w-30">
                  <div class="d-flex px-2 py-1 align-items-center">
                    <div class="ms-4">
                      <p class="text-xs font-weight-bold mb-0">titre:</p>
                      <h6 class="text-sm mb-0">{{ $event['titre'] }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0">reservations:</p>
                    <h6 class="text-sm mb-0">{{ $event['total'] }}</h6>
                  </div>
                </td>
                <td>
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0">places:</p>
                    <h6 class="text-sm mb-0">{{ $event['nombre_place'] }}</h6>
                  </div>
                </td>
                <td class="align-middle text-sm">
                  <div class="col text-center">
                    <p class="text-xs font-weight-bold mb-0">localisation:</p>
                    <h6 class="text-sm mb-0">{{ $event['localisation'] }}</h6>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-5">
      <div class="card shadow mb-4">
        <!-- Card Header -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Billets vendus par Event</h6>
        </div>
        <!-- Card Body -->
        <div>
          <canvas id="myChart"></canvas>
        </div>
        <div class="mt-4 text-center small">
          @foreach ($event_stats as $index => $stat)
          <span class="mr-2">
            <i class="fas fa-circle" style="color: {{ $colors[$index % count($colors)] }}"></i>
            {{ $stat['events_name'] }} ({{ $stat['total_reservation'] }})
          </span>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const data = {
    labels: @json($events),
    datasets: [{
      label: 'total',
      data: @json($counts),
      backgroundColor: @json($colors),
      hoverOffset: 9
    }]
  };
  const doughnut = document.getElementById('myChart');
  new Chart(doughnut, {
    type: 'pie',
    data: data
  });
</script>
@endsection