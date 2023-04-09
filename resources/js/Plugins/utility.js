
import { join, sortBy } from "lodash";




export const dropdowns =(slug,callBack)=>{
    axios.get(route('api.dropdown',{slug})).then(({data})=>{
        callBack(data)
    })
}

export const confirm = (item, model, prop = "title") => {
    return new Promise((resolve, reject) => {
        try {
            const message = `Do yout Want Remove ${model} ${item[prop]}`;

            const d = (cls) => {
                const dom = document.createElement("div");
                dom.classList.add(cls);
                return dom;
            };
            const base = d("vc-overlay");
            const container = d("vc-container");
            const textGrid = document.createElement("span");
            textGrid.classList.add("vc-text-grid");
            const title = document.createElement("h4");
            title.classList.add("vc-title");
            title.textContent = "Confirm";
            const text = document.createElement("p");
            text.classList.add("vc-text");
            text.textContent = message;
            textGrid.appendChild(title);
            textGrid.appendChild(text);
            const btnGrid = d("vc-btn-grid");
            const btnLeft = document.createElement("button");
            btnLeft.classList.add("vc-btn");
            btnLeft.classList.add("left");
            btnLeft.textContent = "Cancel";
            const btn = document.createElement("button");
            btn.classList.add("vc-btn");
            btn.textContent = "Ok";
            btnGrid.appendChild(btnLeft);
            btnGrid.appendChild(btn);

            container.appendChild(textGrid);
            container.appendChild(btnGrid);
            base.appendChild(container);

            document.getElementById("app")?.appendChild(base);

            const remove = () => {
                base.remove();
            };

            btnLeft.addEventListener("click", () => {
                remove();
                resolve(false);
            });
            btn.addEventListener("click", () => {
                remove();

                resolve(true);
            });
        } catch (error) {
            console.error(error);
        }
    });
};

export const validErorrs = (ers) => {
    const res = ers?.response;
    if (!(res && res.status == 422)) {
        return null;
    }
    const errors = res.data.errors;

    try {
        const d = (cls) => {
            const dom = document.createElement("div");
            dom.classList.add(cls);
            return dom;
        };
        const base = d("vc-overlay");
        const container = d("vc-container");
        const textGrid = document.createElement("span");
        textGrid.classList.add("vc-text-grid");
        const title = document.createElement("h3");
        title.classList.add("vc-title");
        title.textContent = "Validation Errors";
        title.style.color = "#c8048f";
        textGrid.appendChild(title);
        let x = {};
        for (const key in errors) {
            let text = document.createElement("p");
            text.classList.add("vc-text");
            text.style.color = "red";
            text.textContent = errors[key];
            textGrid.appendChild(text);
        }

        const btnGrid = d("vc-btn-grid");
        const btnLeft = document.createElement("button");
        btnLeft.classList.add("vc-btn");
        btnLeft.classList.add("left");
        btnLeft.textContent = "Cancel";
        const btn = document.createElement("button");
        btn.classList.add("vc-btn");
        btn.textContent = "Ok";
        btnGrid.appendChild(btnLeft);
        btnGrid.style.gridTemplateColumns = "1fr";
        // btnGrid.appendChild(btn);

        container.appendChild(textGrid);
        container.appendChild(btnGrid);
        base.appendChild(container);

        document.getElementById("app")?.appendChild(base);

        const remove = () => {
            base.remove();
        };

        btnLeft.addEventListener("click", () => {
            remove();
            resolve(false);
        });
        btn.addEventListener("click", () => {
            remove();

            resolve(true);
        });
    } catch (error) {
        console.error(error);
    }
};

export const playNotification = () => {
    var audio = new Audio('./sound/Notification.mp3');
    audio.play();
};

export const removeSuccess = function (tost) {
    tost.init({
        message: "Succsess Fully Removed",
        color: "#432c50",
        closeable: true,
        duration: 4000,
    });
};

export const browserKey = (key) => {
    let str = navigator.userAgent.toLocaleLowerCase().replaceAll(" ", "");
    return str + "." + key;
};
export const whenLogout = () => {
    let keys = ["user", "auth_id", "avatar", "token"];

    keys.forEach((key) => {
        localStorage.removeItem(browserKey(key));
    });
};

export const statusList = sortBy(
    [
        {
            title: "Pending",
            color: "primary",
            status: 0,
        },
        {
            title: "Accepted",
            color: "primary",
            status: 1,
        },
        {
            title: "Working",
            color: "info",
            status: 2,
        },
        {
            title: "Submit",
            color: "success",
            status: 3,
        },
        {
            title: "Completed",
            color: "success",
            status: 4,
        },
        {
            title: "Cancel",
            color: "danger",
            status: 5,
        },
    ],
    "status"
);
