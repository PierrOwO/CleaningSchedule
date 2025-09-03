import{a as y}from"./index-Dq7h7Pqt.js";const i=document.getElementById("button-create-house"),f=document.getElementById("input-house-name"),g=document.getElementById("input-house-address");i&&i.addEventListener("click",function(){f!=""&&g!=""?B():console.log("empty data")});function B(){const s={name:f.value,address:g.value};axios.post("/api/house",s).then(e=>{const c=e.data.message;console.log(c)}).catch(e=>{e.response?(console.log(e.response.data),(e.response.status===419||e.response.status===401)&&console.log(e.response.data.message),e.response.status===422?e.response.data.errors:console.error(e.message)):console.error(e)})}const S=document.getElementById("select-room-house"),r=document.getElementById("btn-add-room"),d=document.getElementById("btn-save-rooms");if(r&&d){let c=function(){const n=document.querySelector("#rooms-table tbody"),t=document.createElement("tr");t.innerHTML=`
      <td colspan="3">No rows added yet</td>
    `,n.appendChild(t)},h=function(){const n=document.querySelector("#rooms-table tbody"),t=n.querySelector("tr td[colspan]");t&&t.parentElement.remove();const a=document.createElement("tr");a.innerHTML=`
        <td>
            <select class="room-type" name="rooms[${s}][type]">
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
        <td><input class="room-number" type="text" name="rooms[${s}][number]" value="${s}"></td>
        <td><button type="button" class="delete-row">Delete</button></td>
      `,n.appendChild(a),m()},m=function(){const n=document.querySelectorAll("#rooms-table tbody tr");n.forEach((t,a)=>{const o=a+1,l=t.querySelector(".room-type");l&&(l.name=`rooms[${o}][type]`);const u=t.querySelector(".room-number");u&&(u.name=`rooms[${o}][number]`,u.value=o)}),s=n.length+1,s==1&&c()},E=function(){const t=document.getElementById("rooms-table").querySelectorAll("tbody tr"),a=[];return t.forEach(o=>{const l=o.querySelector(".room-type").value,u=o.querySelector(".room-number").value;a.push({type:l,number:u})}),a},w=function(){E().forEach(t=>{const a={type:t.type,number:t.number,house:S.value};axios.post("/api/room",a).then(o=>{const l=o.data.message;console.log(l)}).catch(o=>{o.response?(console.log(o.response.data),(o.response.status===419||o.response.status===401)&&console.log(o.response.data.message),o.response.status===422?o.response.data.errors:console.error(o.message)):console.error(o)})})};d.addEventListener("click",function(){w()}),r.addEventListener("click",function(){h()}),c();let s=1;const e=document.querySelector("#rooms-table tbody");e&&e.addEventListener("click",function(n){if(n.target&&n.target.matches("button.delete-row")){const t=n.target.closest("tr");t&&(t.remove(),m())}})}const p=document.getElementById("button-create-tenant"),b=document.getElementById("select-tenant-user"),v=document.getElementById("select-tenant-room");p&&p.addEventListener("click",function(){b!=""&&v!=""?R():console.log("empty data")});function R(){const s={user:b.value,room:v.value};console.log(s),axios.post("/api/tenant",s).then(e=>{const c=e.data.message;console.log(c)}).catch(e=>{e.response?(console.log(e.response.data),(e.response.status===419||e.response.status===401)&&console.log(e.response.data.message),e.response.status===422?e.response.data.errors:console.error(e.message)):console.error(e)})}window.axios=y;y.defaults.headers.common["X-CSRF-TOKEN"]=document.querySelector('meta[name="csrf-token"]').getAttribute("content");
