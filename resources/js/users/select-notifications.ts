import {API} from "@core/services/api";
import {alerts} from "@core/services/alert";

(function () {
    const table = document.getElementById('table_users');
    const selects = table.querySelectorAll('.notifications>select');
    const select = async (event) => {
        const elem = event.target;
        const userId = elem.dataset.userId;
        const loader = elem.nextElementSibling;
        loader.classList.remove("d-none");
        const response = await API.post(`/users/set_notificate/${userId}`, {notificate: elem.value});
        if (response.status) {
            alerts.success("Оповещения изменены!");
        } else {
            alerts.danger("Не удалось изменить оповещения!");
        }
        loader.classList.add("d-none");
    };
    const f = s => {
        s.addEventListener('change', select);
    };
    selects.forEach(f);
})();
