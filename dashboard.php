<?php
if(!authenticated(BASE_URL . "/login")) {
    die();
}

require_once __DIR__ . "/layouts/header.php";


?>

        <main class="content">
          <section class="hero">
            <div class="hero-text">
              <span class="eyebrow" id="heroDate"
                >- · - · -</span
              >
              <h1 class="hero-title">
                  Welcome back, <span class="accent"><?= $_SESSION['user']['name']; ?></span>
              </h1>
            </div>
          </section>
          <section class="kpi-grid" aria-label="Key metrics">
            <article class="kpi-card c-danger">
              <div class="kpi-top">
                <div class="kpi-identity">
                  <div class="kpi-icon danger">
                    <svg viewBox="0 0 24 24">
                      <path
                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                      ></path>
                      <path d="M14 2v6h6M8 13h8M8 17h8M8 9h2"></path>
                    </svg>
                  </div>
                  <div class="kpi-label">Account Types</div>
                </div>
              </div>
              <div class="kpi-value">
                  <?= $conn->query("SELECT COUNT(id) FROM account_type WHERE deleted_at IS NULL;")->fetchColumn(); ?>
              </div>
            </article>
            <article class="kpi-card c-purple">
              <div class="kpi-top">
                <div class="kpi-identity">
                  <div class="kpi-icon purple">
                    <svg viewBox="0 0 24 24">
                      <circle cx="12" cy="8" r="4"></circle>
                      <path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"></path>
                    </svg>
                  </div>
                  <div class="kpi-label">Accounts</div>
                </div>
              </div>
              <div class="kpi-value">
                  <?= $conn->query("SELECT COUNT(id) FROM accounts WHERE deleted_at IS NULL;")->fetchColumn(); ?>
              </div>
            </article>
            <article class="kpi-card c-primary">
              <div class="kpi-top">
                <div class="kpi-identity">
                  <div class="kpi-icon primary">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wrench" viewBox="0 0 16 16">
                        <path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11z"/>
                      </svg>
                  </div>
                  <div class="kpi-label">Actions</div>
                </div>
              </div>
              <div class="kpi-value">
                  <?= $conn->query("SELECT COUNT(id) FROM actions WHERE deleted_at IS NULL;")->fetchColumn(); ?>
              </div>
            </article>
          </section>
        </main>
<?php require_once __DIR__ . "/layouts/footer.php"; ?>
