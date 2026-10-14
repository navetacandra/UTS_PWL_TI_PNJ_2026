<?php
if(!authenticated(BASE_URL . "/login")) {
    die();
}

require __DIR__ . "/layouts/header.php";
?>

        <main class="content">
            <section class="hero">
              <div class="hero-text">
                <h1 class="hero-title">Accounts</h1>
              </div>
              <div class="hero-actions">
                <button class="btn btn--primary" onclick="toggleModal('add-modal', true);">
                  <svg viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"></path>
                  </svg>
                  New Account
                </button>
              </div>
            </section>
            <div class="grid">
              <section class="col-12 card">
                <div class="card-head">
                  <div class="card-title-wrap">
                    <h2 class="card-title">Account list</h2>
                  </div>
                </div>
                <div class="table-scroll">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Account Type</th>
                        <th>ID Type</th>
                        <th>ID Number</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </section>
            </div>
        </main>

        <style>
        .backdrop {
            display: none;
            position: fixed;
            z-index: 99;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #000a;
        }
        </style>
        <div class="backdrop"></div>
        <div class="modal-demo" id="edit-modal" style="display: none; z-index: 100; width: 80vw; position:fixed; top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%);">
            <div class="modal-head">
                <div class="modal-title">Update Account</div>
                <button class="mail-tool" aria-label="Close" onclick="toggleModal('edit-modal', false);">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2" fill="none"></path>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="return updateAccount(event)">
                    <input type="hidden" id="_method" name="_method" value="PUT" />
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" />
                    <input type="hidden" id="id" name="id" />
                    <div class="form-grid">
                      <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" />
                      <div class="field span-2">
                        <label class="field-label" for="name">Name</label>
                        <input
                            id="name"
                            name="name"
                            class="input"
                            type="text"
                            placeholder="Name.."
                          />
                      </div>
                      <div class="field span-2">
                        <label class="field-label" for="email">Email</label>
                        <input
                            id="email"
                            name="email"
                            class="input"
                            type="email"
                            placeholder="you@company.com"
                          />
                      </div>
                      <div class="field span-2">
                        <label class="field-label" for="password">Password</label>
                        <input
                            id="password"
                            name="password"
                            class="input"
                            type="password"
                            placeholder="********"
                          />
                          <div class="field-help">Keep empty will not change password.</div>
                      </div>
                      <div class="field span-2">
                        <label class="field-label" for="status">Status</label>
                        <input
                            id="status"
                            name="status"
                            class="input"
                            type="text"
                            placeholder="Account status.."
                          />
                      </div>
                      <div class="field span-2">
                        <label class="field-label" for="account_type_id">Account Type</label>
                        <select id="account_type_id" name="account_type_id" class="select">
                        </select>
                      </div>
                      <div class="field">
                        <label class="field-label" for="identification_type">ID Type</label>
                        <select id="identification_type" name="identification_type" class="select">
                            <option value="NIP">NIP</option>
                            <option value="NIM">NIM</option>
                        </select>
                      </div>
                      <div class="field">
                        <label class="field-label" for="identification_number">ID Number</label>
                        <input
                            id="identification_number"
                            name="identification_number"
                            class="input"
                            type="number"
                            placeholder="ID Number.."
                          />
                      </div>
                    </div>

                    <div class="modal-foot">
                        <button class="btn btn--ghost" type="reset" onclick="toggleModal('edit-modal', false);">Cancel</button>
                        <button type="submit" class="btn btn--primary">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal-demo" id="add-modal" style="display: none; z-index: 100; width: 80vw; position:fixed; top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%);">
            <div class="modal-head">
                <div class="modal-title">Add Account</div>
                <button class="mail-tool" aria-label="Close" onclick="toggleModal('add-modal', false);">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2" fill="none"></path>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="return addAccount(event)">
                  <div class="form-grid">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" />
                    <div class="field span-2">
                      <label class="field-label" for="name">Name</label>
                      <input
                          id="name"
                          name="name"
                          class="input"
                          type="text"
                          placeholder="Name.."
                        />
                    </div>
                    <div class="field span-2">
                      <label class="field-label" for="email">Email</label>
                      <input
                          id="email"
                          name="email"
                          class="input"
                          type="email"
                          placeholder="you@company.com"
                        />
                    </div>
                    <div class="field span-2">
                      <label class="field-label" for="password">Password</label>
                      <input
                          id="password"
                          name="password"
                          class="input"
                          type="password"
                          placeholder="********"
                        />
                    </div>
                    <div class="field span-2">
                      <label class="field-label" for="status">Status</label>
                      <input
                          id="status"
                          name="status"
                          class="input"
                          type="text"
                          placeholder="Account status.."
                        />
                    </div>
                    <div class="field span-2">
                      <label class="field-label" for="account_type_id">Account Type</label>
                      <select id="account_type_id" name="account_type_id" class="select">
                      </select>
                    </div>
                    <div class="field">
                      <label class="field-label" for="identification_type">ID Type</label>
                      <select id="identification_type" name="identification_type" class="select">
                          <option value="NIP">NIP</option>
                          <option value="NIM">NIM</option>
                      </select>
                    </div>
                    <div class="field">
                      <label class="field-label" for="identification_number">ID Number</label>
                      <input
                          id="identification_number"
                          name="identification_number"
                          class="input"
                          type="number"
                          placeholder="ID Number.."
                        />
                    </div>
                  </div>

                  <div class="modal-foot">
                      <button class="btn btn--ghost" type="reset" onclick="toggleModal('add-modal', false);">Cancel</button>
                      <button type="submit" class="btn btn--primary">Save</button>
                  </div>
                </form>
            </div>
        </div>
        <script>
        async function popEditModal(id) {
          toggleModal('edit-modal', true);

          const res = await fetch(`<?= BASE_URL ?>/api/accounts/get?id=${id}`);
          const json = await res.json();
          if(json.data && json.data.length > 0) {
            const d = json.data[0];
            document.querySelector('#edit-modal #id').value = d.id;
            document.querySelector('#edit-modal #name').value = d.name;
            document.querySelector('#edit-modal #email').value = d.email;
            document.querySelector('#edit-modal #status').value = d.status;
            document.querySelector('#edit-modal #account_type_id').value = d.account_type_id;
            document.querySelector('#edit-modal #identification_type').value = d.identification_type;
            document.querySelector('#edit-modal #identification_number').value = d.identification_number;
          }
        }

        async function toggleModal(id, show) {
          const modal = document.querySelector(`#${id}`);
          console.log(modal.style.display)
          if(modal.style.display == "none") {
            await retrieveAccountType();

            document.querySelector('.backdrop').style.display = "block";
            modal.style.display = "block";
          } else if (modal.style.display == "block"){
            document.querySelector('.backdrop').style.display = "none";
            modal.style.display = "none";
          }
        }

        async function retrieveAccountType() {
          const res = await fetch(`<?= BASE_URL ?>/api/account_type/get`, {
            credentials: "include"
          });
          const json = await res.json();
          if(json.data) {
            console.log(json.data)
            document.querySelectorAll('[name="account_type_id"]').forEach((select) => {
              select.innerHTML = '';
              json.data.forEach((data) => {
                select.innerHTML += `<option value="${data.id}">${data.name}</option>`;
              })
            });
          }
        }

        function deleteForm(id) {
          return `<form method="post" action="#" onsubmit="return deleteAccount(event)">
              <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
              <input type="hidden" name="_method" id="_method" value="DELETE">
              <input type="hidden" name="id" id="id" value="${id}">
              <button class="btn btn--danger" type="submit">Delete</button>
          </form>`;
        }

        async function deleteAccount(e) {
          e.preventDefault();
          if(!window.confirm(`Are you sure want delete ${e.target.id.value.substr(0, 8)}'s account?`)) return;
          const res = await fetch(`<?= BASE_URL ?>/api/accounts/delete`, {
            method: "POST",
            credentials: "include",
            body: new FormData(e.target)
          });

          if(res.ok) retrieveAccounts();
          else alert((await res.json()).message);
        }

        async function addAccount(e) {
          e.preventDefault();
          const res = await fetch(`<?= BASE_URL ?>/api/accounts/create`, {
            method: "POST",
            credentials: "include",
            body: new FormData(e.target)
          });

          if(res.ok) {
            toggleModal('add-modal', false);
            retrieveAccounts();
          } else alert((await res.json()).message);
        }

        async function updateAccount(e) {
          e.preventDefault();
          const res = await fetch(`<?= BASE_URL ?>/api/accounts/update`, {
            method: "POST",
            credentials: "include",
            body: new FormData(e.target)
          });

          if(res.ok) {
            toggleModal('edit-modal', false)
            retrieveAccounts();
          } else alert((await res.json()).message);
        }

        async function retrieveAccounts() {
          const tbody = document.querySelector('tbody');
          const res = await fetch(`<?= BASE_URL ?>/api/accounts/get`, {
            credentials: "include"
          });
          const json = await res.json();
          if(json.data) {
            tbody.innerHTML = '';
            console.log(json.data)
            json.data.forEach((d) => {
              tbody.innerHTML += `<tr><td class="cell-name">${d.id.substr(0, 8)}</td><td>${d.name.substr(0, 10)}</td><td>${d.email}</td><td>${d.status}</td><td>${d.account_type_name || "-"}</td><td>${d.identification_type}</td><td>${d.identification_number}</td><td style="display: flex; gap: .25rem;"><button class="btn btn--warning" onclick="return popEditModal('${d.id}')">Edit</button>${deleteForm(d.id)}</td></tr>`
            })
          }
        };

        retrieveAccounts();
        </script>
<?php require __DIR__ . "/layouts/footer.php"; ?>
