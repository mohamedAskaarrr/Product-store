@extends('layouts.master')

@section('title', 'About Us')

@section('content')
<div class="container py-4">
    <div class="about-card shadow-lg p-4">
        <h1 class="text-gold mb-4 text-center">About Scentora - Your World of Fragrances</h1>

        <div class="row">
            <div class="col-md-12">
                <div class="content-card mb-4">
                    <p class="lead">Welcome to Scentora, your ultimate destination for exquisite fragrances. We are passionate about bringing you a curated selection of the finest perfumes, colognes, and body sprays from around the globe. Our mission is to help you discover scents that express your unique personality and style.</p>

                    <p>At Scentora, we believe that a fragrance is more than just a scent; it's an experience, a memory, and a form of self-expression. Whether you're looking for a signature scent, a gift for a loved one, or exploring new aromatic horizons, we have something for everyone.</p>
                </div>
            </div>
        </div>

        <div class="commitment-section mt-5">
            <h2 class="text-gold mb-4">Our Commitment</h2>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="commitment-card">
                        <i class="fas fa-gem text-gold mb-3"></i>
                        <h3 class="text-gold h5">Quality</h3>
                        <p>We source our fragrances from reputable brands and artisans known for their quality and craftsmanship.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="commitment-card">
                        <i class="fas fa-spray-can text-gold mb-3"></i>
                        <h3 class="text-gold h5">Variety</h3>
                        <p>Our extensive collection includes a diverse range of scents, from classic and timeless to modern and niche.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="commitment-card">
                        <i class="fas fa-heart text-gold mb-3"></i>
                        <h3 class="text-gold h5">Customer Satisfaction</h3>
                        <p>Your satisfaction is our priority. We strive to provide an exceptional shopping experience with helpful customer service.</p>
                    </div>
                </div>
            </div>
        </div>

        <p class="mt-4 text-center">Thank you for choosing Scentora. We hope you enjoy exploring our world of fragrances!</p>
    </div>
</div>

<style>
    body {
        background-color: #2c1e1e;
        color: #f5f5f5;
    }

    .about-card {
        background-color: #2c1e1e;
        border: 1px solid #D4AF37;
        border-radius: 10px;
    }

    .content-card {
        padding: 20px;
        background-color: rgba(44, 30, 30, 0.7);
        border: 1px solid #D4AF37;
        border-radius: 8px;
    }

    .commitment-card {
        height: 100%;
        padding: 20px;
        text-align: center;
        background-color: rgba(44, 30, 30, 0.7);
        border: 1px solid #D4AF37;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .commitment-card:hover {
        transform: translateY(-5px);
    }

    .text-gold {
        color: #D4AF37;
    }

    .fas {
        font-size: 2em;
    }

    h1, h2 {
        font-weight: 600;
    }

    p {
        line-height: 1.6;
    }
</style>
@endsection