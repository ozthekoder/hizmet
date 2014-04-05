<div id="block-details">
    <form name="add-block-form" id="add-block-form" action="add-new-block" method="post">
        <input type="hidden" name="parentid"/>
        <ul>
            <li>
                <label for="title"> Blok Adi: </label>
                <input type="text" name="title" value=""/>
            </li>
            <li>
                <label for="columns"> Sutun Sayisi: </label>
                <select value="1" name="columns">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </li>
            <li>
                <a class="submit-form-button white-gloss-button" style="float:right;">Tamam</a>
            </li>
        </ul>
    </form>
</div>