var md = new MobileDetect(window.navigator.userAgent);
if (md.phone()) {
    console.log(`Device:${md.phone()}`);
    alert(` Recipy ยังไม่รองรับการใช้งานบน SmartPhone อาจะทำให้การแสดงผลของเว็บไซต์ไม่เป็นอย่างที่ควร`);
} else if (md.tablet()) {
    console.log(`Device:${md.tablet()}`);
    alert(` Recipy ยังไม่รองรับการใช้งานบน Tablet อาจะทำให้การแสดงผลของเว็บไซต์ไม่เป็นอย่างที่ควร`);
} else {
    console.log(`Resolution:${screen.width}x${screen.height}`);
    if (screen.height <= 720) {
        alert(` Recipy ยังไม่รองรับการแสดงผลบนหน้าจอที่มีขนาดต่ำกว่า 1280x720 อาจะทำให้การแสดงผลของเว็บไซต์ไม่เป็นอย่างที่ควร`);
    } else if (screen.width <= 720) {
        alert(` Recipy ยังไม่รองรับการแสดงผลบนหน้าจอของคุณ อาจะทำให้การแสดงผลของเว็บไซต์ไม่เป็นอย่างที่ควร`);
    }
}