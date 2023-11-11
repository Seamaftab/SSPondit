@extends('admin.layout.master')

@section('title','Colors')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-1 rounded-lg mt-6">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">Colors</h3>
                    <a href="{{route('colors.create')}}" class="btn btn-outline-primary">Add New</a>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                       	<table class="table table-bordered table-striped">
                       		<thead>
                                <tr>
                                    <td style="font-weight: bold;">Sl.</td>
                                    <td style="font-weight: bold;">Name</td>
                                    <td style="font-weight: bold;">Hex Code</td>
                                    <td style="font-weight: bold;">Demo</td>
                                    <td style="font-weight: bold;">Action</td>
                                </tr>
                       		</thead>
                       		<tbody>
                                @php $serial = 1 @endphp
                                @foreach($colors as $color)
                                <tr>
                                    <td>{{$serial++}}</td>
                                    <td>{{$color->name}}</td>
                                    <td>#{{$color->hex}}</td>
                                    <td>
                                        <div style="width: 20px; height: 20px; background-color: #{{ $color->hex }}; border-radius: 50%;"></div>
                                    </td>


                                    <td>
                                        <a href="{{ route('colors.show', $color->id) }}" class="btn-sm btn-outline-info"><span class="fa fa-search"></span></a>
                                        <a href="{{ route('colors.edit', $color->id) }}" class="btn-sm btn-outline-dark"><span class="fa fa-edit"></span></a>
                                        <form method="POST" action="{{ route('colors.destroy', $color->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn-outline-danger"><span class="fa fa-trash"></span></button>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach
                       		</tbody>
                       	</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection