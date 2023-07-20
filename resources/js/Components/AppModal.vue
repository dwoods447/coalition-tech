<template>
 <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" v-if="isModalVisible">
  <!--
    Background backdrop, show/hide based on modal state.

    Entering: "ease-out duration-300"
      From: "opacity-0"
      To: "opacity-100"
    Leaving: "ease-in duration-200"
      From: "opacity-100"
      To: "opacity-0"
  -->
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

  <div class="fixed inset-0 z-10 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
      <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
         <h2 class="text-center">Edit Task</h2>
        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
           
          <div class="sm:flex sm:items-start">
            
            <form class="w-full" method="POST">
                <meta name="csrf-token" content="{{ csrf_token() }}" ref="csrf">
                <div class="col-span-full mb-3">
                    <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                    <div class="mt-2">
                        <input type="text" name="street-address" id="street-address" autocomplete="street-address" v-model="taskToEdit.title" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                 </div>

                <div class="col-span-full">
                    <label for="about" class="block text-sm font-medium leading-6 text-gray-900">Content</label>
                    <div class="mt-2">
                        <textarea id="about" name="about" rows="3" v-model="taskToEdit.content" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                    </div>
                </div>
            </form>
         
        </div>
        <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
          <button type="button" class="inline-flex w-full justify-center rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 sm:ml-3 sm:w-auto" @click="updateTask(taskToEdit.id)">Update</button>
          <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="emits('done')">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</template>
<script setup>
import { ref, onMounted, computed } from 'vue'
const props = defineProps(['taskId'])
const emits = defineEmits(['done'])
const visible = ref(false)
const title = ref('')
const content = ref('')
const csrf = ref()
const isModalVisible = computed(()=> visible.value)
let taskToEdit = ref()
async function getTask() { 
    console.log(`Get task with id : /fetch/task/${props.taskId}/id`)
     const task = await fetch(`/fetch/task/${props.taskId}/id`)
     taskToEdit  = (await task.json()).task
    console.log(JSON.stringify(taskToEdit))
    visible.value = true
}

async function updateTask(id) { 
    // e.preventDefault()
    console.log(`CSRF in updateTask: ${csrf.value.content}`)
    content.value = taskToEdit.content
    title.value  = taskToEdit.title
    let data = {"title": title.value , "content": content.value, "_token": csrf.value.content}
    await fetch(`/update/${id}/task`, {
    method: "POST",
        headers: {
        'Accept': 'application/json',   
        "Content-Type": "application/json",
        'X-CSRF-TOKEN': csrf.value.content
    },
      body: JSON.stringify(data)
    })
    emits('done')
} 

onMounted(() => { 
     console.log(csrf)
    getTask()
})
</script>