<?php
http_response_code($error_code);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Inter+Tight:wght@500;600;700&amp;family=JetBrains+Mono:wght@400;500&amp;display=swap"
    />
    <title><?= $error_code . " - " . $error_status ?></title>
    <script>
      !(function () {
        try {
          var t = localStorage.getItem("dash26-theme"),
            e = window.matchMedia("(prefers-color-scheme: dark)").matches;
          document.documentElement.setAttribute(
            "data-theme",
            t || (e ? "dark" : "light"),
          );
        } catch (t) {
          document.documentElement.setAttribute("data-theme", "light");
        }
      })();
    </script>
    <script defer="defer" src="<?= BASE_URL ?>/assets/runtime.096d507f.js"></script>
    <script defer="defer" src="<?= BASE_URL ?>/assets/2026.5a84696f.js"></script>
    <link href="<?= BASE_URL ?>/assets/style.76ee5eee.css" rel="stylesheet" />
  </head>
  <body>
    <div class="error-shell">
      <div class="error-card">
        <span class="error-eyebrow">Error · <?= $error_status ?></span>
        <div class="error-code"><?= $error_code ?></div>
        <h1 class="error-title">This page wandered off</h1>
        <p class="error-sub"><?= $error_message ?></p>
        <div class="error-actions">
            <a href="<?= BASE_URL . "/dashboard" ?>" class="btn btn--primary"
            ><svg viewBox="0 0 24 24">
              <path d="M3 12 12 3l9 9" />
              <path d="M5 10v10h14V10" />
            </svg>
            Back to dashboard </a
          ><a href="javascript:history.back()" class="btn btn--ghost"
            ><svg viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" /></svg>
            Go back</a
          >
        </div>
        <div class="error-meta">
            <span><strong>STATUS</strong> <?= $error_code; ?></span>
          <span><strong>CODE</strong> <?= $error_status ?></span>
        </div>
      </div>
    </div>
  </body>
</html>
