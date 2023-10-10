import axios from "axios";
import { errorAlert } from "../../partials/alerts";

export default async function sessionPulse() {
    try {
        const {data} = await axios.get(`${process.env.API}/session-pulse`);

        if (! data.status) {
            errorAlert("La sesión ha caducado. Puede que los cambios no se guarden", false);
        }

        console.log("Ses: ", data);
    } catch(e) {
        console.error("Session pulso: ", e);
    }
};
