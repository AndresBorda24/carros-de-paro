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

export async function getKitsList() {
  return await request(async () => await ax.get(`/kits/get-all`));
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
  return await request(async () => await ax.put(
    `/aperturas/${apId}/update`, body
  ));
}

/** @param carId {string|int} Id del carro */
export async function findDispositivos( carId ) {
  return await request(async () =>
    await ax.get(`/carros/${carId}/get-dispositivos`)
  );
}

/** @param body {object} data del nuevo dispositivo */
export async function createDispositivo( body ) {
  return await request(async () => await ax.post(`/dispositivos/create`, body));
}

/**
 * @param body {object} data del nuevo dispositivo
 * @param id {string|id} dispositivo id
*/
export async function updateDispositivo( id, body ) {
  return await request(async () => await ax.put(
    `/dispositivos/${ id }/update`, body
  ));
}

/**
 * @param body {object} data del nuevo dispositivo
 * @param id {string|id} dispositivo id
*/
export async function deleteDispositivo( id, config ) {
  return await request(async () => await ax.delete(
    `/dispositivos/${ id }/delete`, config
  ));
}

/** @param carId {string|int} Id del carro */
export async function findMedicamentos( carId ) {
  return await request(async () =>
    await ax.get(`/carros/${carId}/get-medicamentos`)
  );
}

/** @param body {object} data del nuevo medicamento */
export async function createMedicamento( body) {
  return await request(async () => await ax.post(`/medicamentos/create`, body));
}

/**
 * @param body {object} data del nuevo medicamento
 * @param id {string|id} medicamento id
*/
export async function updateMedicamento(id, body) {
  return await request(async () => await ax.put(
    `/medicamentos/${id}/update`, body
  ));
}

/** @param conf {object} configuracion de la request */
export async function deleteMedicamento(id, conf) {
  return await request(async() => await ax.delete(
    `/medicamentos/${id}/delete`, conf
  ));
}

/** @param carId {string|int} Carro id */
export async function getAperturas( carId ) {
  return await request(async () => await ax.get(
    `/carros/${carId}/get-aperturas`
  ));
}

/** @param apeId {string|int} Apertura id */
export async function getSingleApertura( apeId ) {
  return await request(async () => await ax.get(
    `/carros/aperturas/${apeId}/get`
  ));
}
