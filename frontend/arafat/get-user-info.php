
<div class="container d-flex justify-content-center align-items-center my-5">
    <div class="card" style="width: 18rem;">
        <div class="card-header">
            user info
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Name : <?php echo $serverData->userName;?></li>
            <li class="list-group-item">Email: <?php echo $serverData->userEmail;?></li>
            <li class="list-group-item">Phone: <?php echo $serverData->userPhone;?> </li>
            <li class="list-group-item">Address: <?php echo $serverData->userAddress;?> </li>
        </ul>
    </div>
</div>