
@extends('layouts.app')

@section('title', 'Quiz & Évaluations')

@section('content')
<div class="container py-5">
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<div class="card shadow-lg border-0 wow fadeInUp">
				<div class="card-body p-4 p-md-5">
					<div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4">
						<h2 class="mb-3 mb-md-0 text-success fw-bold text-center text-md-start">
							<i class="fa fa-question-circle me-2"></i>Quiz & Évaluations
						</h2>
						<div class="w-100 w-md-auto ms-md-4">
							<div class="progress" style="height: 18px; min-width: 160px;">
								<div class="progress-bar bg-success" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">1/5</div>
							</div>
						</div>
					</div>
					<div class="mb-4">
						<div class="alert alert-info d-flex align-items-center mb-3" role="alert">
							<i class="fa fa-lightbulb me-2"></i>
							<span>Répondez à chaque question pour tester vos connaissances sur l’Afrique et le livre !</span>
						</div>
						<h4 class="fw-semibold mb-3">1. Quel est le plus grand pays d'Afrique&nbsp;?</h4>
						<form>
							<div class="row g-2">
								<div class="col-12 col-md-6">
									<div class="form-check mb-2">
										<input class="form-check-input" type="radio" name="q1" id="q1a" value="a">
										<label class="form-check-label" for="q1a">Nigéria</label>
									</div>
									<div class="form-check mb-2">
										<input class="form-check-input" type="radio" name="q1" id="q1b" value="b">
										<label class="form-check-label" for="q1b">Algérie</label>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-check mb-2">
										<input class="form-check-input" type="radio" name="q1" id="q1c" value="c">
										<label class="form-check-label" for="q1c">Égypte</label>
									</div>
									<div class="form-check mb-2">
										<input class="form-check-input" type="radio" name="q1" id="q1d" value="d">
										<label class="form-check-label" for="q1d">Afrique du Sud</label>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="d-grid gap-2 d-md-flex justify-content-between align-items-center mt-4">
						<button class="btn btn-outline-secondary px-4" disabled><i class="fa fa-arrow-left me-2"></i>Précédent</button>
						<button class="btn btn-success px-4">Suivant <i class="fa fa-arrow-right ms-2"></i></button>
					</div>
				</div>
			</div>
			<div class="text-center mt-4">
				<a href="{{ route('formation.modules') }}" class="btn btn-link text-decoration-none"><i class="fa fa-arrow-left me-1"></i>Retour aux modules</a>
			</div>
		</div>
	</div>
</div>
@endsection
