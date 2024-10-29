@extends('layouts.sidebar')
@section('title','Users')
@section('content')

    <main class="table" id="customers_table">
        <section class="table__header">
            <div class="select-box">
                <div class="select-box__current" tabindex="1">
                    <div class="select-box__value">
                        <input class="select-box__input" type="radio" name="Ben" checked="checked"/>
                        <p class="select-box__input-text">
                            @if($role == 'account')
                                Account
                            @elseif($role == 'admin')
                                Admin
                            @else
                                All
                            @endif
                        </p>
                    </div>

                    <div class="select-box__value"><input class="select-box__input" type="radio" id="4" value="5" name="Ben"/></div>
                    <img class="select-box__icon" src="http://cdn.onlinewebfonts.com/svg/img_295694.svg" alt="Arrow Icon" aria-hidden="true"/>
                </div>
                <ul class="select-box__list">
                    <li><a href="{{ route('admin.users') }}" class="select-box__option">All</a></li>
                    <li><a href="{{ route('admin.users', ['role' => 'account']) }}" class="select-box__option">Account</a></li>
                    <li><a href="{{ route('admin.users', ['role' => 'admin']) }}" class="select-box__option">Admin</a></li>
                </ul>
            </div>
            <div class="empty_box_input">
            </div>
            <div class="input-group">
                <input type="search" placeholder="Name / Email / Login Date">
                <img src="{{asset('images/Icon/search.png')}}" alt="">
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                <tr>
                    <th> ID <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Name <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Email <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Login Date <span class="icon-arrow">&UpArrow;</span></th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="tbody_table">
                @foreach($users as $user)
                    <tr class="tr_table">
                        <td> {{ $loop->iteration }} </td>
                        <td> {{ $user->name }} </td>
                        <td> {{ $user->email }} </td>
                        <td> {{ $user->login_date }} </td>
                        <td>
                            @if($user->is_disabled == false)
                                <i class="fas fa-unlock users_lock_open" id="{{ $user->id }}"
                                   data-value="unlock" style="color: rgb(250, 159, 95);"></i>
                            @else
                                <i class="fas fa-lock users_lock_open" id="{{ $user->id }}"
                                   data-value="lock" style="color: red;"></i>
                            @endif
                            <i class="far fa-eye view_profile" id="{{ $user->id }}" style="color:cadetblue"></i>

                            <div class="custom-model-main" id="model{{ $user->id }}">
                                <div class="custom-model-inner">
                                    <div class="custom-model-wrap">
                                        <div class="profile-card js-profile-card">
                                            <div class="profile-card__cnt js-profile-cnt">
                                                <div class="profile-card__name">{{ $user->name }}</div>
                                                <div class="profile-card__txt"><strong>{{ $user->email }}</strong></div>
                                                <div class="profile-card-loc">
                                                   <span class="profile-card-loc__icon">
                                                       <i class="fas fa-user-tag"></i>
                                                   </span>
                                                    <span class="profile-card-loc__txt">
                                                        @foreach($user->roles as $role)
                                                            {{ $role->name }}
                                                        @endforeach
                                                    </span>
                                                </div>
                                                <div class="profile-card-inf">
                                                    <div class="profile-card-inf__item">
                                                        <div class="profile-card-inf__title">
                                                            @if($user->is_disabled == false)
                                                                Active
                                                            @else
                                                                Blocked
                                                            @endif
                                                        </div>
                                                        <div class="profile-card-inf__txt">Is Disabled</div>
                                                    </div>
                                                    <div class="profile-card-inf__item">
                                                        <div class="profile-card-inf__title">{{ $user->login_date }}</div>
                                                        <div class="profile-card-inf__txt">Login Date</div>
                                                    </div>
                                                </div>
                                                <div class="profile-card-ctr">
                                                    <button class="profile-card__button button--orange close-btn">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-overlay"></div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    </main>

@endsection
@section('scripts')
    <script src="{{ asset('js/content/admin.js') }}"></script>
@endsection
