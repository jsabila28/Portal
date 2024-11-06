<div class="events">
    <ul id="events-list">
        <li>
            <div class="time">
                <h2>
                    30 <br><span>November</span>
                </h2>
            </div>
            <div class="details" style="background-image: url('https://i.pinimg.com/564x/b0/68/56/b06856d929b6066d2281c9f065a29e31.jpg');"></div>
            <div style="clear: both;"></div>
        </li>
        <li>
            <div class="time">
                <h2>
                    14 <br><span>December</span>
                </h2>
            </div>
            <div class="details" style="background-image: url('assets/image/party.png');"></div>
            <div style="clear: both;"></div>
        </li>
        <li>
            <div class="time">
                <h2>
                    25 <br><span>December</span>
                </h2>
            </div>
            <div class="details" style="background-image: url('https://i.pinimg.com/564x/fc/6d/7a/fc6d7aaf5ef2ed34132f66616244613b.jpg');"></div>
            <div style="clear: both;"></div>
        </li>
    </ul>
</div>

<script>
const eventsList = document.querySelector('.events ul');
let scrollSpeed = 0.5; 
let position = 0;

eventsList.innerHTML += eventsList.innerHTML; 

function autoScroll() {
  position -= scrollSpeed;
  eventsList.style.transform = `translateY(${position}px)`;

  if (-position >= eventsList.scrollHeight / 2) {
    position = 0;
  }

  requestAnimationFrame(autoScroll);
}

autoScroll();

</script>
