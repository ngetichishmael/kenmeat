
<!-- Admin user profile area -->
<div class="chat-profile-sidebar">
  <header class="chat-profile-header">
    <span class="close-icon">
      <i data-feather="x"></i>
    </span>
    <!-- User Information -->
    <div class="header-profile-sidebar">
      <div class="avatar box-shadow-1 avatar-xl avatar-border">
        <img src="https://ui-avatars.com/api/?name={!! Auth::user()->name !!}&rounded=true&size=80" alt="user_avatar" />
        <span class="avatar-status-online avatar-status-xl"></span>
      </div>
      <h4 class="chat-user-name">{{ auth()->user()->name }}</h4>
      <span class="user-post">Admin</span>
    </div>
    <!--/ User Information -->
  </header>
  <!-- User Details start -->
  <div class="profile-sidebar-area">
    <h6 class="section-label mb-1">About</h6>
    <div class="about-user">
      <textarea
        data-length="120"
        class="form-control char-textarea"
        id="textarea-counter"
        rows="5"
        placeholder="About User"
      >
Dessert chocolate cake lemon drops jujubes. Biscuit cupcake ice cream bear claw brownie brownie marshmallow.</textarea
      >
      <small class="counter-value float-right"><span class="char-count">108</span> / 120 </small>
    </div>
    <!-- To set user status -->
    <h6 class="section-label mb-1 mt-3">Status</h6>
    <ul class="list-unstyled user-status">
      <li class="pb-1">
        <div class="custom-control custom-control-success custom-radio">
          <input
            type="radio"
            id="activeStatusRadio"
            name="userStatus"
            class="custom-control-input"
            value="online"
            checked
          />
          <label class="custom-control-label ml-25" for="activeStatusRadio">Active</label>
        </div>
      </li>
      <li class="pb-1">
        <div class="custom-control custom-control-danger custom-radio">
          <input type="radio" id="dndStatusRadio" name="userStatus" class="custom-control-input" value="busy" />
          <label class="custom-control-label ml-25" for="dndStatusRadio">Do Not Disturb</label>
        </div>
      </li>
      <li class="pb-1">
        <div class="custom-control custom-control-warning custom-radio">
          <input type="radio" id="awayStatusRadio" name="userStatus" class="custom-control-input" value="away" />
          <label class="custom-control-label ml-25" for="awayStatusRadio">Away</label>
        </div>
      </li>
      <li class="pb-1">
        <div class="custom-control custom-control-secondary custom-radio">
          <input type="radio" id="offlineStatusRadio" name="userStatus" class="custom-control-input" value="offline" />
          <label class="custom-control-label ml-25" for="offlineStatusRadio">Offline</label>
        </div>
      </li>
    </ul>
    <!--/ To set user status -->

    <!-- User settings -->
    <h6 class="section-label mb-1 mt-2">Settings</h6>
    <ul class="list-unstyled">
      <li class="d-flex justify-content-between align-items-center mb-1">
        <div class="d-flex align-items-center">
          <i data-feather="check-square" class="mr-75 font-medium-3"></i>
          <span class="align-middle">Two-step Verification</span>
        </div>
        <div class="custom-control custom-switch mr-0">
          <input type="checkbox" class="custom-control-input" id="customSwitch1" checked />
          <label class="custom-control-label" for="customSwitch1"></label>
        </div>
      </li>
      <li class="d-flex justify-content-between align-items-center mb-1">
        <div class="d-flex align-items-center">
          <i data-feather="bell" class="mr-75 font-medium-3"></i>
          <span class="align-middle">Notification</span>
        </div>
        <div class="custom-control custom-switch mr-0">
          <input type="checkbox" class="custom-control-input" id="customSwitch2" />
          <label class="custom-control-label" for="customSwitch2"></label>
        </div>
      </li>
      <li class="mb-1 d-flex align-items-center cursor-pointer">
        <i data-feather="user" class="mr-75 font-medium-3"></i>
        <span class="align-middle">Invite Friends</span>
      </li>
      <li class="d-flex align-items-center cursor-pointer">
        <i data-feather="trash" class="mr-75 font-medium-3"></i>
        <span class="align-middle">Delete Account</span>
      </li>
    </ul>
    <!--/ User settings -->

    <!-- Logout Button -->
    <div class="mt-3">
      <button class="btn btn-primary">
        <span>Logout</span>
      </button>
    </div>
    <!--/ Logout Button -->
  </div>
  <!-- User Details end -->
</div>
<!--/ Admin user profile area -->

<!-- Chat Sidebar area -->
<div class="sidebar-content">
  <span class="sidebar-close-icon">
    <i data-feather="x"></i>
  </span>
  <!-- Sidebar header start -->
  <div class="chat-fixed-search">
    <div class="d-flex align-items-center w-100">
      <div class="sidebar-profile-toggle">
        <div class="avatar avatar-border">
          <img
            src="https://ui-avatars.com/api/?name={!! Auth::user()->name !!}&rounded=true&size=40"
            alt="user_avatar"
            height="42"
            width="42"
          />
          <span class="avatar-status-online"></span>
        </div>
      </div>
      <div class="input-group input-group-merge ml-1 w-100">
        <div class="input-group-prepend">
          <span class="input-group-text round"><i data-feather="search" class="text-muted"></i></span>
        </div>
        <input
          type="text"
          class="form-control round"
          id="chat-search"
          placeholder="Search"
          aria-label="Search..."
          aria-describedby="chat-search"
        />
      </div>
    </div>
  </div>
  <!-- Sidebar header end -->

  <!-- Sidebar Users start -->
  <div id="users-list" class="chat-user-list-wrapper list-group">
    <h4 class="chat-list-title">Unread Chats</h4>
   
    <ul class="chat-users-list chat-list media-list">
    
    

      @foreach ($messages as $message)
              <a  href="{{ route('ChatSupport.show', $message->id) }}">
                <li>
                
                    <span class="avatar"
                      ><img
                        src="{{asset('images/portrait/small/default.png')}}"
                        height="42"
                        width="42"
                        alt="Generic placeholder image"
                      />
                      <span class="avatar-status-away"></span>
                    </span>
                    <div class="chat-info flex-grow-1">
                      <h5 class="mb-0"> {{ $message->sender->name }} </h5>
                      <p class="card-text text-truncate">
                      {{ $message->message }}
                      </p>
                    </div>
                    <div class="chat-meta text-nowrap">
                    <small class="float-right mb-25 chat-time">
                        {{ $message->created_at->format('h:i A') }}
                        @if($message->created_at->isToday())
                        <br>
                            Today
                        @elseif($message->created_at->isYesterday())
                        <br>
                            Yesterday
                        @else
                            {{ $message->created_at->format('') }}
                            <br>
                            {{ $message->created_at->format('F j') }}
                        @endif
                    </small>

                    </div>
                
                  </li>  </a>

            @endforeach
            <li class="no-results">
        <h6 class="mb-0">No New Chats Found</h6>
      </li>
    </ul>

    <h4 class="chat-list-title">Previous Chats</h4>
   
   <ul class="chat-users-list chat-list media-list">
   
   

     @foreach ($readmessages as $mess)
             <a  href="{{ route('ChatSupport.edit', $mess->id) }}">
               <li>
               
                   <span class="avatar"
                     ><img
                       src="{{asset('images/portrait/small/default.png')}}"
                       height="42"
                       width="42"
                       alt="Generic placeholder image"
                     />
                     <span class="avatar-status-busy"></span>
                   </span>
                   <div class="chat-info flex-grow-1">
                     <h5 class="mb-0"> {{ $mess->sender->name }} </h5>
                     <p class="card-text text-truncate">
                     {{ $mess->message }}
                     </p>
                   </div>
                   <div class="chat-meta text-nowrap">
                   <small class="float-right mb-25 chat-time">
                       {{ $mess->created_at->format('h:i A') }}
                       @if($mess->created_at->isToday())
                       <br>
                           Today
                       @elseif($mess->created_at->isYesterday())
                       <br>
                           Yesterday
                       @else
                           {{ $mess->created_at->format('') }}
                           <br>
                           {{ $mess->created_at->format('F j') }}
                       @endif
                   </small>

                   </div>
               
                 </li>  </a>

           @endforeach
           <li class="no-results">
       <h6 class="mb-0">No Chats Found</h6>
     </li>
   </ul>




  </div>
  <!-- Sidebar Users end -->
</div>
<!--/ Chat Sidebar area -->

