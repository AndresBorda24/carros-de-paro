import ax from "@/partials/ax";

async function request( req ) {
  let _data = null
  let error = null

  try {
    const { data } = await req();
    _data = data;
  } catch (e) {
    error = e
    console.error("Request Error: ", e);
  } finally {
    return {
      data: _data,
      error: error
    }
  }
}

/** @param body { object } */
export async function createCarro( body ) {
  return await request(async () => await ax.post(
    "/carros/create", body
  ));
}

/** @param body { object } */
export async function updateCarro(id, body) {
  return await request(async () => await ax.put(
    `/carros/${id}/update`, body
  ));
}

/** @param id {string|int} */
export async function deleteCarro(id) {
  return await request( async () =>
    await ax.delete(`/carros/${id}/delete`)
  );
}

/** Obtiene el listado de carros disponible */
export async function getList() {
  return await request(async () => await ax.get(`/carros/get-all`));
}

/** Obtiene el listado de estantes disponible */
export async function getEstantesList() {
  return await request(async () => await ax.get(`/estantes/get-all`));
}

/** @param body { object } */
export async function createApertura( body ) {
  return await request(async () => await ax.post(
    "/aperturas/create", body
  ));
}

/**
 * @param apId {string|int} id de la apertura
 * @param body {object} Cuerpo de la solicitud
*/
export async function updateApertura(apId, body) {
  return await request(async () => ax.put(
    `/aperturas/${apId}/update`, body
  ));
}

/** @param carId {string|int} Id del carro */
export async function findDispositivos( carId ) {
  return await request(async () =>
    ax.get(`/carros/${carId}/get-dispositivos`)
  );
}

/** @param body {object} data del nuevo dispositivo */
export async function createDispositivo( body ) {
  return await request(async () => ax.post(`/dispositivos/create`, body));
}

/**
 * @param body {object} data del nuevo dispositivo
 * @param id {string|id} dispositivo id
*/
export async function updateDispositivo( id, body ) {
  return await request(async () => ax.put(
    `/dispositivos/${ id }/update`, body
  ));
}

/**
 * @param body {object} data del nuevo dispositivo
 * @param id {string|id} dispositivo id
*/
export async function deleteDispositivo( id, config ) {
  return await request(async () => ax.delete(
    `/dispositivos/${ id }/delete`, config
  ));
}
