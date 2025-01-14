let editMode = false;
let editRowIndex = null;

document.getElementById('myForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Empêche le rechargement de la page

  const titre = document.getElementById('titre').value;
  const auteur = document.getElementById('auteur').value;
  const genre = document.getElementById('genre').value;
  const an = document.getElementById('an').value;

  if (editMode) {
    updateTableRow(editRowIndex, titre, auteur, genre, an);
    document.getElementById('submitBtn').textContent = "Ajouter";
    editMode = false;
    editRowIndex = null;
  } else {

    addToTable(titre, auteur, genre, an);
  }

  document.getElementById('myForm').reset();
});

function addToTable(titre, auteur, genre, an) {
  const table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];

  const newRow = table.insertRow();

  const titreCell = newRow.insertCell(0);
  const auteurCell = newRow.insertCell(1);
  const genreCell = newRow.insertCell(2);
  const anCell = newRow.insertCell(3);
  const actionCell = newRow.insertCell(4);

  titreCell.innerHTML = titre;
  auteurCell.innerHTML = auteur;
  genreCell.innerHTML = genre;
  anCell.innerHTML = an;
  actionCell.innerHTML = '<button onclick="editRow(this)">Modifier</button> <button onclick="deleteRow(this)">Supprimer</button>';
}

function updateTableRow(index, titre, auteur, genre, an) {
  const table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
  const row = table.rows[index];

  row.cells[0].innerHTML = titre;
  row.cells[1].innerHTML = auteur;
  row.cells[2].innerHTML = genre;
  row.cells[3].innerHTML = an;
}

function deleteRow(button) {

  const row = button.parentNode.parentNode;
  row.parentNode.removeChild(row);
}

function editRow(button) {

  const row = button.parentNode.parentNode;
  editRowIndex = row.rowIndex - 1;


  const titre = row.cells[0].innerHTML;
  const auteur = row.cells[1].innerHTML;
  const genre = row.cells[2].innerHTML;
  const an = row.cells[3].innerHTML;


  document.getElementById('titre').value = titre;
  document.getElementById('auteur').value = auteur;
  document.getElementById('genre').value = genre;
  document.getElementById('an').value = an;


  document.getElementById('submitBtn').textContent = "Mettre à jour";
  editMode = true;
}
