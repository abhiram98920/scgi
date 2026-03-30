import asyncio
from pyppeteer import launch

async def test_hamburger():
    browser = await launch(headless=True)
    page = await browser.newPage()
    await page.setViewport({'width': 400, 'height': 800})
    page.on('console', lambda msg: print(f"Browser console: {msg.text}"))
    page.on('pageerror', lambda err: print(f"Browser error: {err}"))
    await page.goto('http://localhost:8080/index.html', {'waitUntil': 'networkidle0'})
    
    # Check if hamburger is visible
    hbg = await page.querySelector('#hbg')
    if hbg:
        print("Hamburger found!")
        bounding_box = await hbg.boundingBox()
        print(f"Hamburger bounding box: {bounding_box}")
        
        # Click it
        await page.click('#hbg')
        print("Clicked hamburger!")
        
        # Check nav state
        nav_ul = await page.querySelector('#navMenu')
        if nav_ul:
            classes = await page.evaluate('(element) => element.className', nav_ul)
            hbg_classes = await page.evaluate('(element) => element.className', hbg)
            print(f"hbg classes after click: '{hbg_classes}'")
            print(f"navMenu classes after click: '{classes}'")
            
            # Force the class
            await page.evaluate("document.querySelector('nav ul').classList.add('open')")
            
            # Take a screenshot
            await page.screenshot({'path': 'mobile_nav_test.png'})
            
            # Get computed styles of navMenu
            styles = await page.evaluate('''() => {
                const el = document.querySelector('#navMenu');
                const comp = window.getComputedStyle(el);
                return {
                    display: comp.display,
                    visibility: comp.visibility,
                    opacity: comp.opacity,
                    transform: comp.transform,
                    pointerEvents: comp.pointerEvents
                }
            }''')
            print(f"navMenu computed styles: {styles}")
        else:
            print("navMenu NOT FOUND!")
    else:
        print("Hamburger NOT FOUND!")
        
    await browser.close()

asyncio.run(test_hamburger())
