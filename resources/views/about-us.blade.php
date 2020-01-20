@extends('layouts.app')

@section('title', 'About us | LetzShare')

@section('content')

<div class="container" id="aboutusView">
    <section id="description">
            <h1 class="display-5">LetzShare - The beauty of Luxembourg</h1>
            <p class="lead">LetzShare is a website for users to upload and share photographs of Luxembourg. These can be rated and commented upon by other users and the site will keep track of the most liked photos. Luxembourg is a small country nestling between France, Germany and Belgium and is not so well known outside the region.</p>
            <p class="lead">By creating a platform to showcase attractive images of the Grand Duchy we hope to play a role in elevating its profile. Rich in history with many monuments and historic buildings this small country is also favoured by many attractive natural landscapes and beauty spots.</p>
            <p class="lead">As well as this Luxembourg has its own unique culture and hugely diverse and multicultural population with a vibrant culture and nightlife reflecting this. Letzshare will be the platform which allows users to share images of all these aspects of Luxembourg.</p>
            <p>&nbsp;</p>
    </section>
    
    <section id="team" class="card text-center">
            <div class="card-header">
                <h1>The LetzShare's Team</h1>
            </div>
    
            <div class="card-body">
                <div class="row">
                    <article id="liliana" class="col-md-6 col-lg-6 mb-5">
                        <div class="">
                            <a href="{{ url('userprofile/10') }}"><img src="{{ asset('uploads/avatars-admin/liliana.jpg')}}" alt="Liliana" title="Liliana" class="rounded-circle mb-3 img-thumbnail" width="150" height="150"></a>
                        </div>
                        <div class="m-3">
                            <h2>Liliana</h2>
                            <a href="https://www.linkedin.com/in/grigorliliana/"><i class="fa-3x fab fa-linkedin"></i></a>&nbsp;
                            <a href="https://github.com/GrigorLiliana/"><i class="fa-3x fab fa-github-square"></i></a>
                            <p>Full Stack Web Developer</p>
                            <p>Back-End: PHP, PHP OOP, Laravel, MySQL Database, SQL, Wordpress</p>
                            <p>Front-End: Web Development & Integration: HTML5, CSS3, SASS, Bootstrap, JavaScript, jQuery, Angular, Ajax, Cordova, Ionic, UI/ UX design, SEO</p>
                        </div>
                    </article>
    
                    <article id="stuart" class="col-md-6 col-lg-6 mb-5">
                        <div class="">
                            <a href="{{ url('userprofile/9') }}"><img src="{{ asset('uploads/avatars-admin/stuart.jpg')}}" alt="Stuart" title="Stuart" class="rounded-circle mb-3 img-thumbnail" width="150" height="150"></a>
                        </div>
                        <div class="m-3">
                            <h2>Stuart</h2>
                            <a href="https://www.linkedin.com/in/stuart-walker-in-lux/"><i class="fa-3x fab fa-linkedin"></i></a>&nbsp;
                            <a href="https://github.com/batecsw"><i class="fa-3x fab fa-github-square"></i></a>
                            <p>Full Stack Web Developer</p>
                            <p>Back-End: PHP, PHP OOP, Laravel, MySQL Database, SQL, Wordpress</p>
                            <p>Front-End: Web Development & Integration: HTML5, CSS3, SASS, Bootstrap, JavaScript, jQuery, Angular, Ajax, Cordova, Ionic, UI/ UX design, SEO</p>
                        </div>
                    </article>
    
                    <article id="ricardo" class="col-md-6 col-lg-6 m-auto">
                        <div class="">
                            <a href="{{ url('userprofile/21') }}"><img src="{{ asset('uploads/avatars-admin/ricardo.jpg')}}" alt="Ricardo" title="Ricardo" class="rounded-circle mb-3 img-thumbnail" width="150" height="150"></a>
                        </div>
                        <div class="m-3">
                            <h2>Ricardo</h2>
                            <a href="https://www.linkedin.com/in/kodii-rr/"><i class="fa-3x fab fa-linkedin"></i></a>&nbsp;
                            <a href="https://github.com/kodiii"><i class="fa-3x fab fa-github-square"></i></a>
                            <p>Full Stack Web Developer</p>
                            <p>Back-End: PHP, PHP OOP, Laravel, MySQL Database, SQL, Wordpress</p>
                            <p>Front-End: Web Development & Integration: HTML5, CSS3, SASS, Bootstrap, JavaScript, jQuery, Angular, Ajax, Cordova, Ionic, UI/ UX design, SEO</p>
                        </div>
                    </article>
    
                    <article id="michel" class="col-md-6 col-lg-6 m-auto">
                        <div class="">
                            <a href="{{ url('userprofile/1') }}"><img src="{{ asset('uploads/avatars-admin/michel.jpg')}}" alt="Michel" title="Michel" class="rounded-circle mb-3 img-thumbnail" width="150" height="150"></a>
                        </div>
                        <div class="m-3">
                            <h2>Michel</h2>
                            <a href="https://www.linkedin.com/in/michelds78/"><i class="fa-3x fab fa-linkedin"></i></a>&nbsp;
                            <a href="https://github.com/michelds78"><i class="fa-3x fab fa-github-square"></i></a>
                            <p>Full Stack Web Developer</p>
                            <p>Back-End: PHP, PHP OOP, Laravel, MySQL Database, SQL, Wordpress</p>
                            <p>Front-End: Web Development & Integration: HTML5, CSS3, SASS, Bootstrap, JavaScript, jQuery, Angular, Ajax, Cordova, Ionic, UI/ UX design, SEO</p>
                        </div>
                </article>
                </div><!-- /.row -->
            </div><!-- /.card-body -->
    </section>
</div>


@endsection
