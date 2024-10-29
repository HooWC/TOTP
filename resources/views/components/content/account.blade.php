@extends('layouts.sidebar')
@section('title','Verification Code')
@section('content')

    <main class="table" id="customers_table">
        <section class="table__header">
            <p class="authenticator_title">CodingTOTP Authenticator</p>
            <button class="custom-btn btn-12 Click-here_authenticator">
                <span>Click!</span>
                <span><i class="fas fa-plus" style="margin-right:10px;"></i>  Add New</span>
            </button>
        </section>

        <div class="custom-model-main-verification">
            <div class="custom-model-inner">
                <div class="custom-model-wrap">
                    <form action="{{Route('add.post')}}" method="post">
                        @csrf

                        <p class="model-title">Select account details</p>

                        <div class="card-form__inner">
                            <div class="card-input">
                                <select name="account_name" class="card-input__input" id="select_account_name">
                                </select>
                            </div>
                            <div class="card-input" id="authenticator_input">
                            </div>

                            <button class="card-form__button" type="submit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-overlay"></div>
        </div>

        <section class="table__body">
            <table>
                <thead>
                <tr>
                    <th> ID</th>
                    <th> Account</th>
                    <th> verification code</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="verification_code_tbody">
                </tbody>
            </table>
        </section>
    </main>

@endsection
@section('scripts')
    <script src="{{asset('js/content/account.js')}}"></script>
@endsection
