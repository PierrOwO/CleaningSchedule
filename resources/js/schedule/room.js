


const selectRoomHouse = document.getElementById('select-room-house');
const btnAddRoom = document.getElementById('btn-add-room');
const btnSaveRooms = document.getElementById('btn-save-rooms');

if (btnAddRoom && btnSaveRooms){
  btnSaveRooms.addEventListener('click', function(){
    createRoom();
  });
  btnAddRoom.addEventListener('click', function(){
    addRoom();
  });

  addEmptyRow();
  let counter = 1;
  const tbody = document.querySelector("#rooms-table tbody");

  if (tbody) {
    tbody.addEventListener("click", function(event) {
      if (event.target && event.target.matches("button.delete-row")) {
        const row = event.target.closest("tr");
        if (row) {
          row.remove();
          renumberRows();
        }
      }
    });
  }

  function addEmptyRow(){
      
      const tbody = document.querySelector("#rooms-table tbody");
      const row = document.createElement("tr");
      row.innerHTML = `
      <td colspan="3">No rows added yet</td>
    `;
    tbody.appendChild(row);

  }
  function addRoom() {
      const tbody = document.querySelector("#rooms-table tbody");
    
      // usuń placeholder "No rows added yet"
      const emptyRow = tbody.querySelector("tr td[colspan]");
      if (emptyRow) emptyRow.parentElement.remove();
    
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>
            <select class="room-type" name="rooms[${counter}][type]">
                <option value="room">Room</option>
                <option value="bedroom">Bedroom</option>
                <option value="kitchen">Kitchen</option>
                <option value="living_room">Living room</option>
                <option value="dining_room">Dining room</option>
                <option value="bathroom">Bathroom</option>
                <option value="toilet">Toilet</option>
                <option value="office">Office</option>
                <option value="garage">Garage</option>
                <option value="attic">Attic</option>
                <option value="basement">Basement</option>
                <option value="laundry">Laundry</option>
                <option value="pantry">Pantry</option>
                <option value="hallway">Hallway</option>
                <option value="closet">Closet</option>
                <option value="porch">Porch</option>
                <option value="balcony">Balcony</option>
                <option value="terrace">Terrace</option>
            </select>
        </td>
        <td><input class="room-number" type="text" name="rooms[${counter}][number]" value="${counter}"></td>
        <td><button type="button" class="delete-row">Delete</button></td>
      `;
      tbody.appendChild(row);
    
      renumberRows();
  }
    
  function removeRow(button){
      const row = button.closest('tr');
      if (row) {
        row.remove();
        renumberRows();
      }
    }
  function renumberRows() {
      const rows = document.querySelectorAll("#rooms-table tbody tr");
      rows.forEach((row, index) => {
        const newIndex = index + 1;
    
        const select = row.querySelector(".room-type");
        if (select) {
          select.name = `rooms[${newIndex}][type]`;
        }
    
        const input = row.querySelector(".room-number");
        if (input) {
          input.name = `rooms[${newIndex}][number]`;
          input.value = newIndex;
        }
      });
    
      counter = rows.length + 1;
      if (counter == 1){
          addEmptyRow();
      }
    }

  function updateRoomsFromTable() {
  const table = document.getElementById('rooms-table'); 
  const rows = table.querySelectorAll('tbody tr'); 
  const rooms = [];

  rows.forEach(row => {
      const type = row.querySelector('.room-type').value;
      const number = row.querySelector('.room-number').value;
      rooms.push({ type, number });
  });

  return rooms;
  }

  function createRoom(){
      const rooms = updateRoomsFromTable(); 

      rooms.forEach(room => {
          const formData ={
              type: room.type,
              number: room.number,
              house: selectRoomHouse.value
          }
          axios.post('/api/room', formData)
          .then(response => {
              const msg = response.data.message;
              console.log(msg);
          })
          .catch(error => {
              if (error.response) {
                  console.log(error.response.data);    
                  if (error.response.status === 419 || error.response.status === 401) {
                      console.log(error.response.data.message);
                  }
                  if (error.response.status === 422) {
                      const errors = error.response.data.errors;
                  } else {
                      console.error(error.message);
                  }
              } else {
                  console.error(error);
              }
          });
      });
  }
}
