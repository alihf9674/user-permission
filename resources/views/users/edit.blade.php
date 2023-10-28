@extends('panel.main')
@section('panel')
    <form method="post" action="">
        @csrf

        <div class="form-group ">
            <span> @lang('users.add role to user') </span>
            <hr>
        </div>
        <div class="form-group">

                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" name='roles[]' value="" class="custom-control-input" id="">
                    <label class="custom-control-label" for=""></label>
                </div>

                <p>
                    @lang('users.there are not any role')
                </p>

        </div>
        <div class="form-group mt-5">
            <span> @lang('users.add permission to user') </span>
            <hr>
        </div>
        <div class="form-group">

                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" name='permissions[]'  value="" class="custom-control-input" id="">
                    <label class="custom-control-label" for=""></label>
                </div>
            @empty
                <p>
                    @lang('users.there are not any role')
                </p>
            @endforelse
        </div>
        <div class="form-group mt-5">
            <button class="btn btn-primary"> @lang('users.update') </button>
        </div>
    </form>
@endsection
