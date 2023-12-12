@extends('admin.layout')

@section('content')

<div class="container mt-5">
    <h1 class="fs-5">Pending</h1>
    <div>Total Pending Reports: {{ $pendingReports }}</div>

    @if(session('errors'))
        <div class="alert alert-danger" id="msgAlert">
            @foreach(session('errors')->all() as $error)
                <i class='fa fa-exclamation-circle'>{{ $error }}</i>
            @endforeach
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" id="msgAlert">
        <i class='fa fa-exclamation-circle'>{{ session('error') }}</i>
        </div>
    @endif

    @if(session('flash_message'))
        <div class="alert alert-success" id="msgAlert">
        <i class='fa fa-check-circle'>{{ session('flash_message') }}</i>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="myDataTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll">
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Course, Year & Section</th>
                            <th>Violation</th>
                            <th>Officer in Charge</th>
                            <th>Time Issued</th>
                            <th>Date Issued</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input report-checkbox" type="checkbox">
                                    </div>
                                </td>
                                <td>{{ $report->student->id_no }}</td>
                                <td>{{ $report->student->fname }} {{ $report->student->lname }}</td>
                                <td>{{ $report->student->course }} {{ $report->student->year }}-{{ $report->student->section }}</td>
                                <td>{{ $report->violation->violation }}</td>
                                @if ($report->officer)
                                    <td>{{ $report->officer->fname }} {{ $report->officer->lname }} (<i>{{ $report->officer->position }}</i>)</td>
                                @else
                                    <td>Admin</td>
                                @endif
                                <td>{{ $report->created_at->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($report->created_at)->format('F j, Y') }}</td>
                                <td class="d-flex justify-content-center text-center">
                                    <form action="{{ route('pending.updateStatus') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="report_id" value="{{ $report->id }}">

                                        <button type="submit" name="action" value="1" class="btn btn-success action-button mb-2">
                                            <i class='fa fa-check-circle'></i><span class="d-none d-sm-inline-block">Approve</span>
                                        </button>

                                        <button type="submit" name="action" value="2" class="btn btn-danger action-button">
                                            <i class='fa fa-times-circle'></i><span class="d-none d-sm-inline-block">Cancel</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <div class="mt-3">
        <button id="approveAllBtn" class="btn btn-success"><i class='fa fa-check-circle'></i>Approve All</button>
        <button id="cancelAllBtn" class="btn btn-danger"> <i class='fa fa-times-circle'></i>Cancel All</button>
    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#checkAll').change(function () {
            $('.report-checkbox').prop('checked', $(this).prop('checked'));
        });

        $('.report-checkbox').change(function () {
            if (!$(this).prop('checked')) {
                $('#checkAll').prop('checked', false);
            }
        });

        $('#approveAllBtn').click(function () {
            approveCancelAll(1);
        });

        $('#cancelAllBtn').click(function () {
            approveCancelAll(2);
        });

        function approveCancelAll(action) {
            var checkedReports = $('.report-checkbox:checked');
            if (checkedReports.length > 0) {
                var reportIds = checkedReports.map(function () {
                    return $(this).closest('tr').find('[name="report_id"]').val();
                }).get();

                $.post('{{ route("pending.updateStatusAll") }}', {
                    _token: '{{ csrf_token() }}',
                    action: action,
                    report_ids: reportIds
                }, function (data) {
                    if (data.flash_message) {
                        $('#msgAlert').html('<div class="alert alert-success"><i class="fa fa-check-circle">' + data.flash_message + '</i></div>');
                    }

                    location.reload();
                });
            } else {
                alert('Please select at least one report.');
            }
        }
    });
</script>
