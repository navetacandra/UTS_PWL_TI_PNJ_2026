<?php
if(!authenticated(BASE_URL . "/login")) {
    die();
}

require __DIR__ . "/layouts/header.php";
?>

        <main class="content">
            <section class="hero">
              <div class="hero-text">
                <h1 class="hero-title">Account Type</h1>
              </div>
              <div class="hero-actions">
                <button class="btn btn--primary" onclick="toggleModal('add-modal', true);">
                  <svg viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"></path>
                  </svg>
                  New Account Type
                </button>
              </div>
            </section>
            <div class="grid">
              <section class="col-12 card">
                <div class="card-head">
                  <div class="card-title-wrap">
                    <h2 class="card-title">Account type list</h2>
                  </div>
                </div>
                <div class="table-scroll">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
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
                <div class="modal-title">Update Account Type</div>
                <button class="mail-tool" aria-label="Close" onclick="toggleModal('edit-modal', false);">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2" fill="none"></path>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="return updateAccountType(event)">
                  <div class="form-grid">
                    <input type="hidden" id="_method" name="_method" value="PUT" />
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" />
                    <input type="hidden" id="id" name="id" />
                    <div class="field span-2">
                      <label class="field-label" for="name">Name</label>
                      <input
                          id="name"
                          name="name"
                          class="input"
                          type="text"
                          placeholder="Action name.."
                        />
                    </div>
                    <div class="field span-2">
                      <label class="field-label" for="bio">Description</label>
                      <textarea
                        id="description"
                        name="description"
                        class="textarea"
                        placeholder="A description for action.."
                      ></textarea>
                    </div>
                  </div>

                  <div class="modal-foot">
                      <button class="btn btn--ghost" type="reset" onclick="toggleModal('edit-modal', false);">Cancel</button>
                      <button type="submit" class="btn btn--warning">Update</button>
                  </div>
                </form>
            </div>
        </div>

        <div class="modal-demo" id="add-modal" style="display: none; z-index: 100; width: 80vw; position:fixed; top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%);">
            <div class="modal-head">
                <div class="modal-title">Add Account Type</div>
                <button class="mail-tool" aria-label="Close" onclick="toggleModal('add-modal', false);">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2" fill="none"></path>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="return addAccountType(event)">
                  <div class="form-grid">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" />
                    <div class="field span-2">
                      <label class="field-label" for="name">Name</label>
                      <input
                          id="name"
                          name="name"
                          class="input"
                          type="text"
                          placeholder="Type name.."
                        />
                    </div>
                    <div class="field span-2">
                      <label class="field-label" for="description">Description</label>
                      <textarea
                        id="description"
                        name="description"
                        class="textarea"
                        placeholder="A description for type.."
                      ></textarea>
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

          const res = await fetch(`<?= BASE_URL ?>/api/account_type/get?id=${id}`);
          const json = await res.json();
          if(json.data && json.data.length > 0) {
            const d = json.data[0];
            document.querySelector('#edit-modal form').reset();
            document.querySelector('#edit-modal #id').value = d.id;
            document.querySelector('#edit-modal #name').value = d.name;
            document.querySelector('#edit-modal #description').value = d.description;
          }
        }

        function toggleModal(id, show) {
          const modal = document.querySelector(`#${id}`);
          console.log(modal.style.display)
          if(modal.style.display == "none") {
            document.querySelector('.backdrop').style.display = "block";
            modal.style.display = "block";
            return
          } else if (modal.style.display == "block"){
            document.querySelector('.backdrop').style.display = "none";
            modal.style.display = "none";
            return
          }
        }



        function deleteForm(id) {
          return `<form method="post" action="#" onsubmit="return deleteAccountType(event)">
              <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
              <input type="hidden" name="_method" id="_method" value="DELETE">
              <input type="hidden" name="id" id="id" value="${id}">
              <button class="btn btn--danger" type="submit">Delete</button>
          </form>`;
        }

        async function deleteAccountType(e) {
          e.preventDefault();
          if(!window.confirm(`Are you sure want delete ${e.target.id.value.substr(0, 8)}'s account type?`)) return;
          const res = await fetch(`<?= BASE_URL ?>/api/account_type/delete`, {
            method: "POST",
            credentials: "include",
            body: new FormData(e.target)
          });

          if(res.ok) retrieveAccountTypes();
          else alert((await res.json()).message);
        }

        async function addAccountType(e) {
          e.preventDefault();
          const res = await fetch(`<?= BASE_URL ?>/api/account_type/create`, {
            method: "POST",
            credentials: "include",
            body: new FormData(e.target)
          });

          if(res.ok) {
            toggleModal('add-modal', false);
            retrieveAccountTypes();
          } else alert((await res.json()).message);
        }

        async function updateAccountType(e) {
          e.preventDefault();
          const res = await fetch(`<?= BASE_URL ?>/api/account_type/update`, {
            method: "POST",
            credentials: "include",
            body: new FormData(e.target)
          });

          if(res.ok) {
            toggleModal('edit-modal', false)
            retrieveAccountTypes();
          } else alert((await res.json()).message);
        }

        async function retrieveAccountTypes() {
          const tbody = document.querySelector('tbody');
          const res = await fetch(`<?= BASE_URL ?>/api/account_type/get`, {
            credentials: "include"
          });
          const json = await res.json();
          if(json.data) {
            tbody.innerHTML = '';
            json.data.forEach((d) => {
              tbody.innerHTML += `<tr><td class="cell-name">${d.id.substr(0, 8)}</td><td>${d.name.substr(0, 10)}</td><td>${d.description.substr(0, 32)}</td><td style="display: flex; gap: .25rem;"><button class="btn btn--warning" onclick="return popEditModal('${d.id}')">Edit</button>${deleteForm(d.id)}</td></tr>`
            })
          }
        };

        retrieveAccountTypes();
        </script>
<?php require __DIR__ . "/layouts/footer.php"; ?>
