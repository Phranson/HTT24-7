function applyMarqueeEffectToOverFlowText() {
    const courseTitles = document.querySelectorAll(".marquee");
    courseTitles.forEach(container => {
        let text = container.querySelector('h3');
        if (text && text.scrollWidth > container.clientWidth) {
            container.classList.add("overflowText");
        } else {
            container.classList.remove("overflowText");
        }
    });
}
window.addEventListener("load", applyMarqueeEffectToOverFlowText);
window.addEventListener("resize", applyMarqueeEffectToOverFlowText);