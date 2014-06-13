<div class="list-group">
    <a href="{{ URL::to('user') }}" class="list-group-item">My Profile</a>
    <a href="{{ URL::to('user/profile') }}" class="list-group-item">Update Profile</a>
    <a href="{{ URL::to('user/change') }}" class="list-group-item">Change Password</a>
    <a href="{{ URL::to('/logout') }}" class="list-group-item">Logout</a>
</div>