export function registerTask(description) {
    let task = {
        "description": description,
        "priority": "normal",
        "updateDate": new Date().toISOString(),
    }
    return JSON.stringify(task, null, 2); // objeto, reemplazo (nulo), espacios de indexado
}
