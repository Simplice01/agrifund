<!DOCTYPE html>
<html lang="zxx" class="js">
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Softnio">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
		<link rel="shortcut icon" href="clients/images/favicon.png">
		<title>Tableau de bord user</title>
		<link rel="stylesheet" href="{{asset('clients/css/dashlite.css')}}">
		<link id="skin-default" rel="stylesheet" href="{{asset('clients/css/theme.css')}}">
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-91615293-4"></script>
		<link href="https://cdn.jsdelivr.net/npm/quill@2.0.1/dist/quill.snow.css" rel="stylesheet" />
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());
			gtag('config', 'UA-91615293-4');
		</script>
	</head>
	<body class="nk-body ui-rounder has-sidebar ui-light " >
		<div class="nk-app-root">
			<div class="nk-main ">
				@include('user\partials\_sidebar')

				<div class="nk-wrap ">
					@include('user\partials\_nav')
					@yield('content')
					@include('user\partials\_footer')
					<div class="pmo-lv pmo-dark active">
                       
															@if(auth()->user()->role === 'admin' )
															<a class="pmo-wrap" target="_blank" href="">
																<div class="pmo-text text-white">
															  Attention !,vous etes en mode admin et vos opérations sont irrevestibles <strong></strong> 
																<em class="ni ni-arrow-long-right"></em>
															</div>
												    	</a>
																@endif
															@if(auth()->user()->role === 'investor' )

															@endif
															
															

                               
                    </div>
                    
				</div>
			</div>
		</div>
		
		<script src="{{asset('clients/js/bundle.js')}}"></script>
		<script src="{{asset('clients/js/scripts.js')}}"></script>
		<script src="{{asset('clients/js/demo-settings.js')}}"></script>
		<script src="{{asset('clients/js/chart-ecommerce.js')}}"></script>
		<!-- Include the Quill library -->
		<script src="https://cdn.jsdelivr.net/npm/quill@2.0.1/dist/quill.js"></script>

		<!-- Initialize Quill editor -->
		<script>
		const quill = new Quill('#editor', {
			modules: {
                    toolbar: [["bold", "italic", "underline", "strike"], ["blockquote", "code-block"], [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }], [{
                        script: "sub"
                    }, {
                        script: "super"
                    }], [{
                        indent: "-1"
                    }, {
                        indent: "+1"
                    }], [{
                        header: [1, 2, 3, 4, 5, 6]
                    }], [{
                        color: []
                    }, {
                        background: []
                    }], [{
                        font: []
                    }], [{
                        align: []
                    }], ["clean"]]
                },
			theme: 'snow'
		});
		</script>
	</body>
</html>
