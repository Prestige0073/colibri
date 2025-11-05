@extends('layouts.app')

@section('title', 'Certification professionnelle | Colibri Littéraire')
@section('meta_description', 'Obtenez une certification reconnue dans les métiers du livre africain avec Colibri Littéraire. Découvrez nos parcours certifiants, modalités et avantages.')

@section('content')
<div class="container py-5">
	<div class="row justify-content-center mb-5">
		<div class="col-lg-8 text-center">
			<h1 class="display-5 fw-bold text-success mb-3 wow fadeInUp">Certification professionnelle</h1>
			<p class="lead text-secondary mb-4 wow fadeInUp" data-wow-delay="0.2s">
				Valorisez vos compétences et boostez votre carrière dans les métiers du livre africain grâce à nos certifications reconnues.
			</p>
			<div class="d-grid gap-3 d-md-flex justify-content-center">
				<a href="#parcours" class="btn btn-success btn-lg px-4 wow fadeInUp" data-wow-delay="0.3s"><i class="fa fa-graduation-cap me-2"></i>Découvrir les parcours</a>
				<a href="#modalites" class="btn btn-outline-success btn-lg px-4 wow fadeInUp" data-wow-delay="0.4s"><i class="fa fa-info-circle me-2"></i>Modalités</a>
			</div>
		</div>
	</div>
	<div class="row align-items-center mb-5" id="parcours">
		<div class="col-md-6 mb-4 mb-md-0 wow fadeInLeft">
			<img src="{{ asset('img/certification.png') }}" alt="Certification Colibri Littéraire" class="img-fluid rounded shadow">
		</div>
		<div class="col-md-6 wow fadeInRight">
			<h2 class="fw-bold text-success mb-3">Nos parcours certifiants</h2>
			<ul class="list-group list-group-flush mb-3">
				<li class="list-group-item bg-transparent"><i class="fa fa-check-circle text-success me-2"></i>Éditeur / éditrice professionnel·le</li>
				<li class="list-group-item bg-transparent"><i class="fa fa-check-circle text-success me-2"></i>Libraire & gestionnaire de librairie</li>
				<li class="list-group-item bg-transparent"><i class="fa fa-check-circle text-success me-2"></i>Responsable de diffusion/distribution</li>
				<li class="list-group-item bg-transparent"><i class="fa fa-check-circle text-success me-2"></i>Animateur·rice d’ateliers littéraires</li>
			</ul>
			<p class="mb-0 text-secondary">Chaque parcours inclut des modules spécialisés, des études de cas, et une évaluation finale pour valider vos acquis.</p>
		</div>
	</div>
	<div class="row mb-5" id="modalites">
		<div class="col-lg-10 mx-auto">
			<div class="card shadow border-0 wow fadeInUp">
				<div class="card-body p-4">
					<h3 class="fw-bold text-success mb-3"><i class="fa fa-info-circle me-2"></i>Modalités & avantages</h3>
					<ul class="list-unstyled mb-4">
						<li class="mb-2"><i class="fa fa-certificate text-success me-2"></i>Certification délivrée par Colibri Littéraire et ses partenaires</li>
						<li class="mb-2"><i class="fa fa-clock text-success me-2"></i>Formations 100% en ligne, à votre rythme</li>
						<li class="mb-2"><i class="fa fa-users text-success me-2"></i>Accompagnement par des experts du secteur</li>
						<li class="mb-2"><i class="fa fa-star text-success me-2"></i>Accès à la communauté et au réseau professionnel</li>
						<li class="mb-2"><i class="fa fa-trophy text-success me-2"></i>Attestation officielle et badge numérique</li>
					</ul>
					<a href="{{ route('contact.index') }}" class="btn btn-success btn-lg"><i class="fa fa-envelope me-2"></i>Demander plus d'informations</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-lg-8 text-center">
			<h4 class="fw-bold text-success mb-3">Prêt·e à certifier vos compétences&nbsp;?</h4>
			<div class="d-grid gap-3 d-md-flex justify-content-center">
				<a href="{{ route('formation.modules') }}" class="btn btn-success btn-lg px-4 wow fadeInUp"><i class="fa fa-book me-2"></i>Commencer une formation</a>
				<a href="{{ route('formation.quiz') }}" class="btn btn-outline-success btn-lg px-4 wow fadeInUp"><i class="fa fa-question-circle me-2"></i>Tester mes connaissances</a>
			</div>
		</div>
	</div>
</div>
@endsection
