@extends('admin.components.base')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $topic->title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $topic->title }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-6">
                            <!-- PIE CHART -->
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">Partisipasi Ko.Ko</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="pieChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        </div>
                        <!-- /.col (LEFT) -->
                        <div class="col-md-6">

                            <!-- STACKED BAR CHART -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Partisipasi Ko.Ko</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="stackedBarChart"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        </div>
                        <!-- /.col (RIGHT) -->
                    </div>
                </div>
                <div class="col-md-12">

                    <!-- Box Comment -->
                    <div class="card card-widget">
                        <div class="card-header">
                            <div class="user-block">
                                <img class="img-circle" src="{{ url('admin/assets') }}/dist/img/user1-128x128.jpg" alt="User Image">
                                <span class="username"><a href="#">{{ $topic->user_name }}</a></span>
                                <span class="description">{{ $topic->group_name }} - {{ $topic->created_at }}</span>
                            </div>
                            <!-- /.user-block -->
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" title="Mark as read">
                                    <i class="far fa-circle"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h1 class="text-center mb-4">
                                {!! $topic->title !!}
                            </h1>
                            <div>
                                {!! $topic->body !!}
                            </div>

                            <!-- Social sharing buttons -->
                            <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i>
                                Share</button>
                            {{-- <button type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i>
                                Like</button> --}}
                            <span class="float-right text-muted">
                                {{ $topic->jumlah_like }} likes - {{ $topic->jumlah_dislike }} likes - {{ $topic->jumlah_comment }} comments</span>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer card-comments">

                            @foreach ($topic_comments as $comment)
                            <div class="card-comment">
                                <!-- User image -->
                                <img class="img-circle img-sm" src="{{ url('admin/assets') }}/dist/img/user3-128x128.jpg" alt="User Image">

                                <div class="comment-text">
                                    <span class="username">
                                        Anonim
                                        <span class="text-muted float-right">{{ $comment->created_at ?? "" }}</span>
                                    </span><!-- /.username -->
                                    {!! $comment->comment !!}
                                </div>
                                <!-- Social sharing buttons -->
                                <button type="button" class="btn btn-sm btn-danger mt-2" style="margin-left: 40px;"><i class="fas fa-trash"></i>
                                    Hapus</button>

                                <!-- /.comment-text -->
                            </div>
                            @endforeach
                            <!-- /.card-comment -->
                        </div>
                        <!-- /.card-footer -->
                        {{-- <div class="card-footer">
                            <form action="#" method="post">
                                <img class="img-fluid img-circle img-sm" src="{{ url('admin/assets') }}/dist/img/user4-128x128.jpg" alt="Alt Text">
                                <!-- .img-push is used to add margin to elements next to floating images -->
                                <div class="img-push">
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Press enter to post comment">
                                </div>
                            </form>
                        </div> --}}
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col (RIGHT) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('js')

    <!-- ChartJS -->
    <script src="/admin/assets/plugins/chart.js/Chart.min.js"></script>
    <script>
        $(function() {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            //--------------
            //- AREA CHART -
            //--------------

            // Get context with jQuery - using jQuery's .get() method.

            chartBatang();
            chartPie();

        })

        function chartPie() {
            $.get("{{ route('admin.topic.data.pie', $url) }}", (result) => {
                let label = [];
                let data = [];
                result.forEach(e => {
                    label.push(e.type == 0 ? "Dislike" : "Like");
                    data.push(e.total);
                });
                //-------------
                //- DONUT CHART -
                //-------------
                // Get context with jQuery - using jQuery's .get() method.
                var donutData = {
                    labels: label,
                    datasets: [{
                        data: data,
                        backgroundColor: ['#f56954', '#00a65a'],
                    }]
                }

                //-------------
                //- PIE CHART -
                //-------------
                // Get context with jQuery - using jQuery's .get() method.
                var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                var pieData = donutData;
                var pieOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                }

                //Create pie or douhnut chart
                // You can switch between pie and douhnut using the method below.
                new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: pieData,
                    options: pieOptions
                });
            })
        }

        function chartBatang() {
            $.get("{{ route('admin.topic.data.batang', $url) }}", (result) => {
                console.log(result);

                var areaChartData = {
                    labels: result.label,
                    datasets: [{
                            label: 'Komentar',
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: result.data
                        }
                        // {
                        //   label               : 'Electronics',
                        //   backgroundColor     : 'rgba(210, 214, 222, 1)',
                        //   borderColor         : 'rgba(210, 214, 222, 1)',
                        //   pointRadius         : false,
                        //   pointColor          : 'rgba(210, 214, 222, 1)',
                        //   pointStrokeColor    : '#c1c7d1',
                        //   pointHighlightFill  : '#fff',
                        //   pointHighlightStroke: 'rgba(220,220,220,1)',
                        //   data                : [65, 59, 80, 81, 56, 55, 40, 80, 81, 56, 55, 40]
                        // },
                    ]
                }
                var barChartData = $.extend(true, {}, areaChartData)
                var temp0 = areaChartData.datasets[0]
                // var temp1 = areaChartData.datasets[1]
                barChartData.datasets[0] = temp0
                // barChartData.datasets[1] = temp0

                //---------------------
                //- STACKED BAR CHART -
                //---------------------
                var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
                var stackedBarChartData = $.extend(true, {}, barChartData)

                var stackedBarChartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }

                new Chart(stackedBarChartCanvas, {
                    type: 'bar',
                    data: stackedBarChartData,
                    options: stackedBarChartOptions
                })
            })
        }
    </script>
@endpush
