@extends('student.layout')

@section('content')

@php
    $student = \App\Models\Students::where('id_no', Auth::user()->id_no)->first();
@endphp

<div class="container">
    <div class="row">

        <div class="col-lg-4">
            <div class="card" style="padding-right: 20px">
                <h4>MISSION</h4>
                <img src="http://wallup.net/wp-content/uploads/2016/06/23/383074-New_Zealand-landscape.jpg" alt="Profile Picture" class="card-img-top img">
                <div class="card-body">
                    <p class="card-text">
                        "To Offer Affordable And Quality Education Primarily But Not, Exclusively, To The Cordovanhons With The End In View That Education Shall Be Within Everyone's Reach To Provide Tertiary Education, Technical, Vocational And Other Practical Courses"
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="padding-right: 20px">
                <h4>VISSION</h4>
                <img src="http://wallup.net/wp-content/uploads/2016/06/23/383074-New_Zealand-landscape.jpg" alt="Profile Picture" class="card-img-top img">
                <div class="card-body">
                    <p class="card-text">
                        "A community-based college that shall offer quality education at a low tuition fee."
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="padding-right: 20px">
                <h4>Core Values</h4>
                <img src="http://wallup.net/wp-content/uploads/2016/06/23/383074-New_Zealand-landscape.jpg" alt="Profile Picture" class="card-img-top img">
                <div class="card-body">
                    <p class="card-text">
                       Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, doloremque culpa quaerat laborum cupiditate nostrum nobis laboriosam! Nihil expedita, dolorum voluptatum dolore soluta atque? Iusto officiis aut suscipit eos molestiae.
                    </p>
                </div>
            </div>
        </div>


        <div class="col-lg-12">
            <div class="card" style="padding-right: 20px">
                <h4>STUDENT'S MANUAL</h4>
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="https://wallpaperaccess.com/full/112722.jpg" class="d-block w-100 carousel-img" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                          <h5>First slide label</h5>
                          <p>Some representative placeholder content for the first slide.</p>
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="https://images.freecreatives.com/wp-content/uploads/2016/04/Calm-Mountain-Lake-Landscape-Wallpaper.jpg" class="d-block w-100 carousel-img" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                          <h5>Second slide label</h5>
                          <p>Some representative placeholder content for the second slide.</p>
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="https://wallup.net/wp-content/uploads/2016/03/10/318375-nature-landscape-lake-mountain-forest-wildflowers-spring-pine_trees-path-Switzerland-HDR.jpg" class="d-block w-100 carousel-img" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                          <h5>Third slide label</h5>
                          <p>Some representative placeholder content for the third slide.</p>
                        </div>
                      </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
            </div>
        </div>

    </div>
</div>

@endsection

<style>
    .card .img {
        height: 300px;
        object-fit: cover;
    }

    .card {
        margin-bottom: 30px;
    }

    .card .carousel-img {
        height: 500px;
        object-fit: cover;
    }

    .card-body p {
        font-size: .8rem;
        text-align: justify;
    }
</style>
