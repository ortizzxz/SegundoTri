export function registerTask(description) {
    let task = {
        "description": description,
        "priority": "normal",
        "updateDate": new Date().toISOString(),
        'completed': false
    }
    return JSON.stringify(task, null, 2); // objeto, reemplazo (nulo), espacios de indexado
}


export function isDescriptionValid(description) {
    return description.length > 2;
}

export function countCompletedTasks(notes){
    var count = 0;
    var notesArray = notes._rawValue;
    notesArray.forEach(note => {
        if(note.completed){ 
            count++ 
        }
    });
    return count;
}