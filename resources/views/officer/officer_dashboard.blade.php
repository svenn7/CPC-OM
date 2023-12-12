@extends('officer.layout')

@section('content')

@php
    $officer = \App\Models\Officers::where('id_no', Auth::user()->id_no)->first();
@endphp

<div class="container dashboard-content px-3 pt-4">
    <h2 class="fs-5"> Dashboard</h2>


<div class="card--container">
    <h3 class="main--title">
        Welcome {{ $officer->fname }} {{ $officer->mname }} {{ $officer->lname }}!
        <span class="status-badge
            @if($officer->status == 1) status-active
            @elseif($officer->status == 0) status-inactive
            @else status-unknown
            @endif">
            @if($officer->status == 1)
                Active
            @elseif($officer->status == 0)
                Inactive
            @else
                Unknown
            @endif
        </span>
    </h3>


    <div class="card--container-wrapper">
        <a href="{{ url('/admin/students') }}" class="card--wrapper">
            <div class="totals--card light-red">
                <div class="card--header">
                    <div class="amount">
                        <span class="title">
                            Total Reports
                        </span>
                        <span class="value">
                            {{ $reports->count() }}
                        </span>
                    </div>
                    <i class="fa fa-group icon dark-red"></i>
                </div>
            </div>
        </a>
    </div>
</div>

</div>

@endsection

<style>
    .card--container {
        background: #fff;
        padding: 2rem;
        border-radius: 10px;
    }

    .card--container-wrapper {
        display: flex;
        flex-wrap: wrap;
    }

    .card--container-wrapper a{
        text-decoration: none;
        color: #111;
    }

    .card--wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 10px 10px;
        cursor: pointer;
    }

    .main--title {
        color: rgba(14, 32, 51, 0.937);
        padding-bottom: 10px;
        font-size: 15px;
        display: flex;
    }

    .totals--card {
        background: rgb(299, 223, 223);
        border-radius: 10px;
        padding: 1.2rem;
        min-width: 250px;
        height: 100px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.5 ease-in-out;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .totals--card:hover {
        transform: translateY(-5px);
        color: #111;
    }

    .card--header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .amount {
        display: flex;
        flex-direction: column;
    }

    .title {
        font-size: 12px;
        font-weight: 200;
    }

    .value {
        font-size: 24px;
        font-family: "Courier New", Courier, monospace;
        font-weight: 600;
    }

    .icon {
        color: #fff;
        padding: 1rem;
        height: 60px;
        width: 60px;
        text-align: center;
        padding-top: 20px;
        border-radius: 50%;
        font-size: 1.5rem;
        background: red;
    }

    /* color css */
    .light-red {
        background: rgb(251, 226, 233);
    }

    .light-purple {
        background: rgb(254, 226, 254);
    }

    .light-green {
        background: rgb(235, 254, 235);
    }

    .light-blue {
        background: rgb(236, 236, 254);
    }

    .dark-red {
        background: red;
    }

    .dark-purple {
        background: purple;
    }

    .dark-green {
        background: green;
    }

    .dark-blue {
        background: blue;
    }

    /*status*/
    .status-badge {
        width: 80px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        font-size: .6rem;
        margin-left: 10px;
    }

    .status-active {
        background-color: #28a745;
        color: #fff;
    }

    .status-inactive {
        background-color: #6c757d;
        color: #fff;
    }

    .status-unknown {
        background-color: #ffc107;
        color: #fff;
    }

    @media only screen and (max-width: 768px) {
        .totals--card {
            width: 290px;
        }
    }
</style>
