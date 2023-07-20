<template>
  <div class="h-screen flex items-center justify-center">

         <div class="items-center">
                <h2>List of Tasks</h2>
       <draggable
        class="w-[500px]"
        v-model="tasks" 
        group="tasks" 
        @start="drag=true" 
        @end="drag=false" 
        item-key="id">
        <template #item="{element}">
           <div class="bg-white px-4 py-5 sm:px-6 mb-4">
            <div class="flex space-x-3">
                <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </div>
                <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-900">
                    <a href="#" class="hover:underline">{{element.title }}</a>
                </p>
                <p class="text-sm text-gray-500">
                    <a href="#" class="hover:underline">{{element.updated_at}}</a>
                </p>
                </div>
                <div class="flex flex-shrink-0 self-center">
                <div class="relative inline-block text-left">
                    <div>
                        <button type="button" class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true" @click="editTask(element.id)" title="Edit Task">
                        <span class="sr-only">Edit Task</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                        </svg>
                    </button>
                    </div>
                    <div>
                    <button type="button" class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true" title="Remove Task" @click="removeTask(element.id)">
                        <span class="sr-only">Remove Task</span>
                         <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                      </svg>
                    </button>
                    </div>

                </div>
                </div>
            </div>
          
            </div>
        </template>
        </draggable>
    </div>
      <AppModal v-if="currentlyEditing" :taskId="currentTaskId" @done="doneEditingTask"/>
</div>
  
</template>


<script setup>
import AppModal from '@/Components/AppModal.vue'
import { ref, computed, onMounted } from 'vue'
import draggable from 'vuedraggable'
const tasks = ref([]);
const taskId = ref(null)
const currentTaskId = computed(()=> taskId.value)
const editingTask = ref(false);
const currentlyEditing = computed(()=> editingTask.value)
async function getTasks() { 
    console.log(`Getting tasks....`);
    const resp = await fetch('/view/tasks');
    tasks.value = (await resp.json()).tasks;
}

function editTask(task_id) {
    console.log('Editing task ' + task_id)
    taskId.value = null
    taskId.value = task_id
    editingTask.value = true

}

function doneEditingTask() {
    editingTask.value = false
    getTasks();
}

async function removeTask(task_id) { 
    await fetch(`/remove/${task_id}/task`);
    getTasks();
}
// const allTasks = computed(() => tasks.value);
onMounted(() => { 
    getTasks();
})
</script>