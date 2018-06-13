@extends('layouts.admin')

@section('content')
<section class="content-header">
  	<h1>Posts</h1>
  	<ol class="breadcrumb">
    	<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    	<li class="active">Posts</li>
  	</ol>
</section>
<section id="app" class="content container-fluid">
	<posts></posts>
</section>
@endsection