window.onload = function() {
  setTimeout(function() {
    getemp('id_pr');
  }, 1000);
};

function checkIfEmpty(value) {
  if (value.trim().length === 0) {
    return true; // Value is empty
  } else {
    return false; // Value is not empty
  }
}


function getemp(a) {
  const value_a = document.getElementById(a).value;
  const eventtype = document.getElementById('eventtype').value;

  if (!checkIfEmpty(value_a)) {
    getFeedback(value_a).then(data => {
      if (eventtype=='update') {
        createempup(data);
      } else {
        createemp(data);
      }
      
    });
  } else {
    console.log('empty');
  }
}

function getFeedback(value_a) {
  return axios
    .get(`/project/${value_a}/employee`, {
      params: {
        _token: '{{ csrf_token() }}'
      }
    })
    .then(response => {
      return response.data;
    })
    .catch(error => {
      console.log('Error:', error);
      return null;
    });
}
function createemp(data) {
const contentFeedDiv = document.getElementById('id_em');
//const ee = document.getElementById('emp').value;
contentFeedDiv.replaceChildren();
const rowDiv = document.createElement('option');
  rowDiv.textContent ='Add employee'; 
  rowDiv.setAttribute('value','');
    rowDiv.setAttribute ("selected", true);
    contentFeedDiv.appendChild(rowDiv);
data.forEach(element => {
  const rowDiv = document.createElement('option');
  rowDiv.textContent = element.name; 
  rowDiv.setAttribute('value', element.id);
  
  contentFeedDiv.appendChild(rowDiv);
});
}
function createempup(data) {
  const contentFeedDiv = document.getElementById('id_em');
  const ee = document.getElementById('emp').value;
  contentFeedDiv.replaceChildren();
  const rowDiv = document.createElement('option');
    rowDiv.textContent ='Add employee'; 
    rowDiv.setAttribute('value','');
    contentFeedDiv.appendChild(rowDiv);
  data.forEach(element => {
    const rowDiv = document.createElement('option');
    rowDiv.textContent = element.name; 
    rowDiv.setAttribute('value', element.id);
    if(element.id==ee){
      rowDiv.setAttribute ("selected", true);
    }
    contentFeedDiv.appendChild(rowDiv);
  });
  }

function select_emp(event) {
const value = event.target.value;
if (!checkIfEmpty(value)) {
  const cntdiv = document.getElementById('tim');
  cntdiv.style.display = 'block';

  getdata(value).then(res => {
    same(res)
  });
} else {
  const cntdiv = document.getElementById('tim');
  cntdiv.style.display = 'none';
}
}


function getdata(id){
  return axios
    .get(`/User/${id}/time`, {
      params: {
        _token: '{{ csrf_token() }}'
      }
    })
    .then(response => {
      return response.data;
    })
    .catch(error => {
      console.log('Error:', error);
      return null;
    });
}
function createTimelineStep(title, date1, date2,linkHref) {
  const timelineStepsDiv = document.getElementById("item");
  const timelineStep = document.createElement("div");
  timelineStep.classList.add("timeline-step");
  const anchorTag = document.createElement("a");
  anchorTag.classList.add("nav-link");
  anchorTag.setAttribute("href", linkHref);
  anchorTag.setAttribute("target", '_blank');
  const timelineContent = document.createElement("div");
  timelineContent.classList.add("timeline-content");
  timelineContent.setAttribute("data-toggle", "popover");
  timelineContent.setAttribute("data-trigger", "hover");
  timelineContent.setAttribute("data-placement", "top");
  timelineContent.setAttribute("title", "");
  const innerCircle = document.createElement("div");
  innerCircle.classList.add("inner-circle");
  const taskTitle = document.createElement("p");
  taskTitle.classList.add("h6", "mt-3", "mb-1");
  taskTitle.textContent = title;
  const dateSpan1 = document.createElement("span");
  dateSpan1.classList.add("h6", "text-muted", "mb-0", "mb-lg-0");
  dateSpan1.textContent = date1;
  const dateSpan2 = document.createElement("span");
  dateSpan2.classList.add("h6", "text-muted", "mb-0", "mb-lg-0");
  dateSpan2.textContent = date2;
  timelineContent.appendChild(innerCircle);
  timelineContent.appendChild(taskTitle);
  timelineContent.appendChild(dateSpan1);
  timelineContent.appendChild(dateSpan2);
  anchorTag.appendChild(timelineContent);
  timelineStep.appendChild(anchorTag);
  timelineStepsDiv.appendChild(timelineStep);
}
function no_item() {
  const timelineStepsDiv = document.getElementById("item");
  const timelineStep = document.createElement("div");
  timelineStep.classList.add("timeline-step");
  const timelineContent = document.createElement("div");
  timelineContent.classList.add("timeline-content");
  timelineContent.setAttribute("data-toggle", "popover");
  timelineContent.setAttribute("data-trigger", "hover");
  timelineContent.setAttribute("data-placement", "top");
  const title = document.createElement("p");
  title.classList.add("h6", "mt-3", "mb-1");
  title.textContent = "No Task";

  timelineContent.appendChild(title);
  timelineStep.appendChild(timelineContent);
  timelineStepsDiv.replaceChildren();
  timelineStepsDiv.appendChild(timelineStep);
}
function start__(){
  const end=document.getElementById('start').value

  const date = new Date(end);
  date.setDate(date.getDate() - 15);
  const formattedDate = date.toISOString().slice(0, 10);
  const value=document.getElementById('id_em').value

 
  getdatabyda(value,formattedDate).then(res => {
    same(res)
  });
  }
function end__(){
  const end=document.getElementById('end').value
  const value=document.getElementById('id_em').value
  getdatabyda(value,end).then(res => {
    same(res)
  });
}
function getdatabyda(id,data){
  return axios
    .get(`/User/${id}/time`, {
      params: {
        _token: '{{ csrf_token() }}',
        start_date:data
      }
    })
    .then(response => {
      return response.data;
    })
    .catch(error => {
      console.log('Error:', error);
      return null;
    });
  }
  function same(res){
    document.getElementById('date').innerHTML = res.start + "/" + res.end;
    document.getElementById('start').value = res.start;
    document.getElementById('end').value = res.end;

    if (res.data.length > 0) {
      const timelineStepsDiv = document.getElementById("item");
      timelineStepsDiv.innerHTML = "";

      res.data.forEach(item => {
        createTimelineStep(item['name'], item['date_deb'], '2023-07-31', `/task/${item['id']}`);
      });
    } else {
      const timelineStepsDiv = document.getElementById("item");
      timelineStepsDiv.innerHTML = "";
      no_item();
    }
  }