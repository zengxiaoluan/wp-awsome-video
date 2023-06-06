import Hls from "hls.js";
import React from "react";
import { useEffect } from "react";

function getSrc(source: Record<string, any>) {
  let preserves = ["line", "线路"];
  let map = {} as any;
  for (let [k, v] of Object.entries(source)) {
    if (k.startsWith(preserves[0]) || k.startsWith(preserves[1])) {
      map[k] = Array.isArray(v) ? v[0] : v;
    }
  }

  return map;
}

export default function App() {
  let map = getSrc(
    (window as any).__meta || {
      line1: "https://vip.lzcdn2.com/20220318/37_8786d09c/1200k/hls/mixed.m3u8",
      line2: "xx",
    }
  );

  let keys = Object.keys(map);

  useEffect(() => {
    play(map[keys[0]]);
  });

  function play(videoSrc: string) {
    const video = document.getElementById("video") as any;
    if (Hls.isSupported()) {
      const hls = new Hls();
      hls.loadSource(videoSrc);
      hls.attachMedia(video);
      hls.on(Hls.Events.MANIFEST_PARSED, function () {
        // video.play();
        // video.download();
      });
    } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
      video.src = videoSrc;
      video.addEventListener("loadedmetadata", function () {
        // video.play();
      });
    }
  }

  return (
    <>
      <video
        controls
        autoPlay={false}
        style={{ width: "100%" }}
        id="video"
      ></video>

      {keys.map((k) => {
        return (
          <button key={k} onClick={play.bind(null, map[k])}>
            {k}
          </button>
        );
      })}
    </>
  );
}
