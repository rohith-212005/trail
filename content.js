let isMuted = false;

function detectPlatformAd() {
  const host = window.location.hostname;
  const video = document.querySelector("video");

  if (!video) return false;

  switch (host) {
    case "www.youtube.com":
      return document.querySelector(".ad-showing");

    case "www.hotstar.com":
      // Try detecting based on "Ad" label or short duration
      const adLabel = document.querySelector('[aria-label="Advertisement"]') ||
                      document.querySelector('[class*="ad"]');

      const isShortAd = video.duration < 60 && !video.paused;
      return adLabel || isShortAd;

    default:
      return false;
  }
}

function checkAd() {
  const video = document.querySelector("video");
  if (!video) return;

  const adPlaying = detectPlatformAd();

  if (adPlaying && !isMuted) {
    video.muted = true;
    isMuted = true;
    console.log("Ad detected: Muted.");
  } else if (!adPlaying && isMuted) {
    video.muted = false;
    isMuted = false;
    console.log("Ad ended: Unmuted.");
  }
}

setInterval(checkAd, 1000); // Check every second
