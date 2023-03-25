@if ( !empty($contentHeader['title']) || !empty($contentHeader['bcs']) )
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				@isset($contentHeader['title'])
					<div class="col-sm-6">
						<h1>
							{{ $contentHeader['title'] }}
							@isset($contentHeader['subtitle'])
								<small class="text-md text-black-50 pl-1">{{ $contentHeader['subtitle'] }}</small>
							@endisset
						</h1>
					</div>
				@endisset
				@isset($contentHeader['bcs'])
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							@forelse ($contentHeader['bcs'] as $bc)
							<li class="breadcrumb-item @isset($bc['active']) active @endisset">
								@if (!empty($bc['link']))
								<a href="{{ $bc['link'] }}">
									{{ $bc['title'] }}
								</a>
								@else
								{{ $bc['title'] }}
								@endif
							</li>
							@endforeach
						</ol>
					</div>
				@endisset
			</div>
		</div>
	</section>
@endif