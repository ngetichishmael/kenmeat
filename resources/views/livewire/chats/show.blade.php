@extends('layouts.app2')

@section('title', 'Customer Support')
@include('partials.menu')
<!-- BEGIN: Content -->
<div class="app-content content chat-application">
  <!-- BEGIN: Header -->
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>

  <div class="content-area-wrapper container-xxl p-0">
    <div class="sidebar-left">
      <div class="sidebar">
        @include('livewire.chats.app-chat-sidebar')
      </div>
    </div>
    <div class="content-right">
      <div class="content-wrapper">
        <div class="content-body">
          <div class="body-content-overlay"></div>
          <!-- Main chat area -->
          <section class="chat-app-window">
            <!-- Active Chat -->
            <div class="active-chat">
              <!-- Chat Header -->
              <div class="chat-navbar">
                <header class="chat-header">
                  <div class="d-flex align-items-center">
                    <div class="sidebar-toggle d-block d-lg-none mr-1">
                      <i data-feather="menu" class="font-medium-5"></i>
                    </div>
                    <div class="avatar avatar-border user-profile-toggle m-0 mr-1">
                      <img src="{{ asset('images/portrait/small/default.png') }}" alt="avatar" height="36" width="36" />
                      <span class="avatar-status-busy"></span>
                    </div>
                    <h6 class="mb-0"> {{ $message->sender->name }}</h6>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="dropdown">
                      <button class="btn-icon btn btn-transparent hide-arrow btn-sm dropdown-toggle" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="more-vertical" id="chat-header-actions" class="font-medium-2"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="chat-header-actions">
                        <a class="dropdown-item" href="javascript:void(0);">Clear Chat</a>
                        <a class="dropdown-item" href="{{ route('ChatSupport') }}">Back</a>
                      </div>
                    </div>
                  </div>
                </header>
              </div>
              <!--/ Chat Header -->

              <!-- User Chat messages -->
              <div class="user-chats">
                <div class="chats">
                  @foreach ($senderMessages as $msg)
                  <div class="chat chat-left">
                    <div class="chat-avatar">
                      <span class="avatar box-shadow-1 cursor-pointer">
                        <img src="{{ asset('images/portrait/small/default.png') }}" alt="avatar" height="36"
                          width="36" />
                      </span>
                    </div>
                    <div class="chat-body">
                      <div class="chat-content">
                        <p> {{ $msg->message }} </p>
                      </div>
                    </div>
                  </div>

                  @foreach ($senderResponses as $resp)
                  @if ($resp->message_id === $msg->id)
                  <div class="chat">
                    <div class="chat-avatar">
                      <span class="avatar box-shadow-1 cursor-pointer">
                        <img src="{{ asset('images/portrait/small/pic.png') }}" alt="avatar" height="36" width="36" />
                      </span>
                    </div>
                    <div class="chat-body">
                      <div class="chat-content">
                        <p> {{ $resp->response }} </p>
                      </div>
                    </div>
                  </div>
                  @endif
                  @endforeach
                  @endforeach

                  <div class="divider">
                    <div class="divider-text">UNRESPONDED MESSAGE</div>
                  </div>
                  <div class="chat chat-left">
                    <div class="chat-avatar">
                      <span class="avatar box-shadow-1 cursor-pointer">
                        <img src="{{ asset('images/portrait/small/default.png') }}" alt="avatar" height="36"
                          width="36" />
                      </span>
                    </div>
                    <div class="chat-body">
                      <div class="chat-content">
                        <p> {{ $message->message }} </p>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <!-- User Chat messages -->

              <!-- Submit Chat form -->
              <form class="chat-app-form" action="{{ route('ChatSupport.update', $message->id) }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="input-group input-group-merge mr-1 form-send-message">
                  <input type="text" name="response" class="form-control message" placeholder="Type your message"
                    required />
                </div>
                <button type="submit" class="btn btn-primary send">
                  <i data-feather="send" class="d-lg-none"></i>
                  <span class="d-none d-lg-block">Send</span>
                </button>
              </form>
              <!--/ Submit Chat form -->
            </div>
            <!--/ Active Chat -->
          </section>
          <!--/ Main chat area -->

          <!-- User Chat profile right area -->
          <div class="user-profile-sidebar">
            <header class="user-profile-header">
              <span class="close-icon">
                <i data-feather="x"></i>
              </span>
              <!-- User Profile image with name -->
              <div class="header-profile-sidebar">
                <div class="avatar box-shadow-1 avatar-border avatar-xl">
                  <img src="{{ asset('images/portrait/small/default.png') }}" alt="user_avatar" height="70"
                    width="70" />
                  <span class="avatar-status-busy avatar-status-lg"></span>
                </div>
                <h4 class="chat-user-name">{{ $message->sender->name }}</h4>
                <span class="user-post">Account :  {{ $message->sender->account_type }} </span>
              </div>
              <!--/ User Profile image with name -->
            </header>
            <div class="user-profile-sidebar-area">
              <!-- About User -->
              <h6 class="section-label mb-1">About</h6>
              <p>The user registered this account at {{ $message->sender->created_at }}</p>
              <!-- About User -->
              <!-- User's personal information -->
              <div class="personal-info">
                <h6 class="section-label mb-1 mt-3">Personal Information</h6>
                <ul class="list-unstyled">
                  <li class="mb-1">
                    <i data-feather="mail" class="font-medium-2 mr-50"></i>
                    <span class="align-middle"> {{ $message->sender->email }} </span>
                  </li>
                  <li class="mb-1">
                    <i data-feather="phone-call" class="font-medium-2 mr-50"></i>
                    <span class="align-middle"> {{ $message->sender->phone_number }}</span>
                  </li>
                  <li>
                    <i data-feather="clock" class="font-medium-2 mr-50"></i>
                    <span class="align-middle"> {{ $message->sender->created_at }}</span>
                  </li>
                </ul>
              </div>
              <!-- User's personal information -->
              <!-- User Contact -->
              <h6 class="section-label mb-1 mt-3">Contact</h6>
              <ul class="list-unstyled">
                <li class="mb-1">
                  <i data-feather="check" class="font-medium-2 mr-50"></i>
                  <span class="align-middle">Email: {{ $message->sender->email }}</span>
                </li>
                <li class="mb-1">
                  <i data-feather="check" class="font-medium-2 mr-50"></i>
                  <span class="align-middle">Phone: {{ $message->sender->phone_number }}</span>
                </li>
              </ul>
              <!-- User Contact -->
              <!-- User Bio -->
              <h6 class="section-label mb-1 mt-3">Bio</h6>
              <p>{{ $message->sender->name }} has not added a bio yet.</p>
              <!-- User Bio -->
            </div>
          </div>
          <!-- User Chat profile right area -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: Content -->

